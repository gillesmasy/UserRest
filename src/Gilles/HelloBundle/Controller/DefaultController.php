<?php

namespace Gilles\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Gilles\HelloBundle\Entity\Utilisateur;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_hello")
     * @Template
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
    
    /*
     * @Route("/Create", name="_hello_create")
     */
    public function CreateAction()
    {
        throw new \Exception('Not Implemented');
        
        $user = new Utilisateur();
        
        $user->setName("Masy");
        $user->setFirstname("Gilles");
        $user->setMail("gilles.masy@gmail.com");
        $user->setPassword("test");
        
        $validator = $this->get('validator');
        $errorList = $validator->validate($user);
        
        if(count($errorList) <= 0){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            //TODO Adapter le message au JSON
            return new Response('User Created');
        }else{
            //TODO Récupérer les erreurs et Adapter le message au JSON
            $msgError = "";
            foreach($errorList as $error)
                $msgError .= $error->getMessage() . "\n";
            return new Response('Une (ou plusieurs) erreur(s) est/sont survenues : '. $msgError);
        }
    }
    
    /*
     * @Route("/Get", name="_hello_get")
     */
    public function GetAction($id)
    {
        $user = $this->getDoctrine()
                ->getRepository('GillesHelloBundle:Utilisateur')
                ->find($id)
        ;        
        if(! $user){
            throw $this->createNotFoundException('Aucun utilisateur pour cet Id : '.$id);
        }
        
        //TODO : réponse JSON de l'entité Utilisateur
        throw new \Exception('Not Implemented');
    }
    
    /*
     * @Route("/Update", name="_hello_update")
     */
    public function UpdateAction()
    {
        throw new \Exception('Not Implemented');
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('GillesHelloBundle:Utilisateur')->find($id);
        
        if(! $user){
            throw $this->createNotFoundException('Aucun utilisateur pour cet Id : '.$id);
        }
        
        $user->setName();
        $user->setFirstname();
        $user->setMail();
        $user->setPassword();
        
        //Update
        $em->flush();
        
        //Retour à la page d'index
        return $this->redirect($this->generateUrl('index'));
    }
    
    /*
     * @Route("/Delete", name="_hello_delete")
     */
    public function DeleteAction($id)
    {
        throw new \Exception('Not Implemented');
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('GillesHelloBundle:Utilisateur')->find($id);
        
        if(! $user){
            throw $this->createNotFoundException('Aucun utilisateur pour cet Id : '.$id);
        }
        
        $em->remove($user);
        
        $em->flush();
    }
}
