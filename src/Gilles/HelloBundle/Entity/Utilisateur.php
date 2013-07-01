<?php

/**
 * Description of User
 *
 * @author G.Masy
 */

namespace Gilles\HelloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gilles\HelloBundle\Validator\Constraints as GillesAssert;

/**
 * @ORM\Entity
 * @ORM\Table(name="utilisateur")
 */
class Utilisateur {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotNull(message="Le nom doit être renseigné.")
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotNull(message="Le prénom doit être renseigné.")
     */
    protected $firstname;
    
    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\NotNull(message="L'adresse e-mail doit être renseignée")
     * @Assert\Email(message="L'adresse '{{ value }}' n'est pas une adresse e-mail valide.")
     */
    protected $mail;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Le password doit être renseigné.")
     * @GillesAssert\PasswordStrategy
     */
    protected $password;

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
        $this->password = $password;
    
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
}