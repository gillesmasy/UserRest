<?php

namespace Gilles\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Gilles\HelloBundle\Entity\Utilisateur;

class SecureController extends Controller
{
    /**
     * @Route("/", name="_hello_list")
     * @Template
     */
    public function ListAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        
        $users = $this->getDoctrine()
                ->getRepository('GillesHelloBundle:Utilisateur')
                ->findAll()
        ;
        
        return array('users' => $users);
    }
    
    /**
     * @Route("/login_check", name="_hello_security_check")
     */
    public function securityCheckAction(Request $request)
    {
    }
     
    /**
     * @Route("/", name="_hello_login")
     * @Template
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        return $this->render('GillesHelloBundle:Secure:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }
}

?>
