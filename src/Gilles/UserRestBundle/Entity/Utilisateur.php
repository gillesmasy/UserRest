<?php

/**
 * Description of User
 *
 * @author G.Masy
 */

namespace Gilles\UserRestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

use Gilles\UserRestBundle\Validator\Constraints as GillesAssert;

/**
 * @ORM\Entity
 * @ORM\Table(name="utilisateur")
 */
class Utilisateur implements UserInterface, \Serializable {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Le nom doit être renseigné.")
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Le prénom doit être renseigné.")
     */
    protected $firstname;
    
    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank(message="L'adresse e-mail doit être renseignée")
     * @Assert\Email(message="L'adresse '{{ value }}' n'est pas une adresse e-mail valide.")
     */
    protected $mail;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le password doit être renseigné.")
     * @GillesAssert\PasswordStrategy
     */
    protected $password;
    
    protected $encoderFactory;

    public function __construct(array $data, $factoryEncoder){
        $this->update($data, $factoryEncoder);
    }
    public function update(array $data, $factoryEncoder){
        $this->encoderFactory = $factoryEncoder;
        
        if($data){
            if(isset($data['name']))      $this->setName($data['name']);
            if(isset($data['firstname'])) $this->setFirstname($data['firstname']);
            if(isset($data['mail']))      $this->setMail($data['mail']);
            if(isset($data['password']))  $this->setPassword($data['password']);
        }
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Utilisateur
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Utilisateur
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return Utilisateur
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    
        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Utilisateur
     */
    public function setPassword($password)
    {
        if($this->encoderFactory){
            $encoder = $this->encoderFactory->getEncoder($this);

            $this->password = $encoder->encodePassword($password, $this->getSalt());
        }else
            throw new \Exception('Factory Encoder is not defined');
        
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /*
     * Implements UserInterface
     */
    public function getRoles(){
        //Pour des raisons de facilité (et exigence du projet), on considère que tous les utilisateurs, une fois authentifié, sont admin
        return array('ROLE_ADMIN');
    }
    
    public function getSalt(){
        return "Th1s_1s-a_sal7!";
    }
    
    public function getUsername(){
        //Considérons que l'email est le login
        return $this->getMail();
    }
    
    public function eraseCredentials(){
    }
    
    /*
     * Implements Serializable
     * http://symfony.com/fr/doc/2.2/book/security.html#charger-les-utilisateurs-de-la-base-de-donnees
     */
    public function serialize(){
        return serialize(array(
            'id' => $this->id,
            'name' => $this->name,
            'firstname' => $this->firstname,
            'mail' => $this->mail,
            'password' => $this->password,
        ));
    }
    
    public function unserialize($serializedData){
        $rawData = unserialize($serializedData);
        
        $this->id = $rawData['id'];
        $this->name = $rawData['name'];
        $this->firstname = $rawData['firstname'];
        $this->mail = $rawData['mail'];
        $this->password = $rawData['password'];
    }
    
    public function toJson(){
        return json_encode(
                array(
                    'id' => $this->getId(),
                    'name' => $this->getName(),
                    'firstname' => $this->getFirstname(),
                    'mail' => $this->getMail(),
                )
        );
    }
}