<?php

namespace Gilles\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Gilles\HelloBundle\Entity\Utilisateur;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_hello")
     * @Template
     */
    public function indexAction($name =null)
    {
        return array('name' => $name);
    }
    
    /*
     * @Route("/Create", name="_hello_create")
     */
    public function CreateAction(Request $request)
    {
        $response = new Response();
        
        $content = $request->getContent();
        if(! $content){
            //Retour BAD REQUEST - sans texte
            return $response
                    ->setStatusCode(400)
                    ->setContent(json_encode("Empty value"));
        }
        $data = json_decode($content, true);
        
        $user = new Utilisateur($data, $this->get('security.encoder_factory'));
        
        $validator = $this->get('validator');
        $errorList = $validator->validate($user);
        
        //L'utilisateur est validé
        if(count($errorList) <= 0){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            //Retour OK
            return $response->setStatusCode(200);
        }else{
            $msgError = array();
            foreach($errorList as $error)
                $msgError[$error->getPropertyPath()]= $error->getMessage();
            
            //Retour BAD REQUEST - avec les messages d'erreurs
            return $response
                    ->setStatusCode(400)
                    ->setContent(json_encode($msgError));
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
