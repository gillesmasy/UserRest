<?php

namespace Gilles\UserRestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Gilles\UserRestBundle\Entity\Utilisateur;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_hello")
     * @Template
     */
    public function indexAction($name =null){
        return array('name' => $name);
    }
    
    /*
     * @Route("/rest", name="_hello_create")
     */
    public function CreateAction(){
        $response = new Response();
        
        try{
            $content = $this->get('request')->getContent();
            if(! $content){
                //Retour BAD REQUEST - sans texte
                return $response
                        ->setStatusCode(400)
                        ->setContent(json_encode("Empty value"));
            }
            $data = json_decode($content, true);
            
            if($data)
                $user = new Utilisateur($data, $this->get('security.encoder_factory'));
            else
                return $response
                        ->setStatusCode(400)
                        ->setContent(json_encode("Empty data"));
            
            $validator = $this->get('validator');
            $errorList = $validator->validate($user);

            //L'utilisateur est validé
            if(count($errorList) <= 0){
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                //Retour OK
                return $response
                        ->setStatusCode(200)
                        ->setContent($user->getId());
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
        catch(\Exception $e){
            return $response
                    ->setStatusCode(500);
        }
    }
    
    /*
     * @Route("/rest", name="_hello_get")
     */
    public function GetAction($id){
        $response = new Response();
        
        try{
            if(! $id){
                return $response->setStatusCode(400);
            }

            $user = $this->getDoctrine()
                    ->getRepository('GillesUserRestBundle:Utilisateur')
                    ->find($id);        

            if(! $user){
                return $response
                        ->setStatusCode(400)
                        ->setContent(json_encode(array('error' => 'Id Unknown')));
            }

            return $response
                    ->setContent($user->toJson());
        }
        catch(\Exception $e){
            return $response
                    ->setStatusCode(500);
        }
    }
    
    /*
     * @Route("/rest", name="_hello_update")
     */
    public function UpdateAction($id){
        $response = new Response();
        
        try{
            if(! $id){
                return $response
                        ->setStatusCode(400)
                        ->setContent(json_encode(array('error' => 'Id User Unknown')));
            }

            $user = $this->getDoctrine()
                    ->getRepository('GillesUserRestBundle:Utilisateur')
                    ->find($id);
            if(! $user){
                return $response->setStatusCode(400)
                        ->setContent(json_encode(array('error' => 'User Unknown')));
            }

            $content = $this->get('request')->getContent();
            if(! $content){
                return $response
                        ->setStatusCode(400)
                        ->setContent(json_encode(array('error' => 'No update')));
            }

            //Mettre à jour l'utilisateur
            $data = json_decode($content, true);
            if($data)
                $user->update($data);
            else
                return $response
                        ->setStatusCode(400)
                        ->setContent(json_encode(array('error' => 'No update')));

            $validator = $this->get('validator');
            $errorList = $validator->validate($user);

            //L'utilisateur est validé
            if(count($errorList) <= 0){
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                //Retour OK
                return $response
                        ->setStatusCode(200);
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
        catch(\Exception $e){
            return $response
                    ->setStatusCode(500);
        }
    }
    
    /*
     * @Route("/rest", name="_hello_delete")
     */
    public function DeleteAction($id){
        $response = new Response();
        
        try{
            if(! $id){
                //Retour BAD REQUEST - sans texte
                return $response
                        ->setStatusCode(400)
                        ->setContent(json_encode(array('error' => 'No user to delete')));
            }

            $user = $this->getDoctrine()
                    ->getRepository('GillesUserRestBundle:Utilisateur')
                    ->find($id);

            if($user){
                $em = $this->getDoctrine()->getManager();
                $em->remove($user);
                $em->flush();
            }
            //Si l'utilisateur n'est pas connu, on considère qu'il est déjà supprimé => ce n'est pas un cas d'erreur

            return $response->setStatusCode(200);
        }
        catch(\Exception $e){
            return $response
                    ->setStatusCode(500);
        }
    }
}
