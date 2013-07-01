<?php

namespace Gilles\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Gilles\HelloBundle\Entity\Utilisateur;

class SecureController extends Controller
{
    /**
     * @Route("/", name="_hello_list")
     * @Template
     */
    public function ListAction(){
        
    }
    
    /**
     * @Route("/login_check", name="_hello_security_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }
    
    /**
     * @Route("/", name="_hello_login")
     * @Template
     */
    public function LoginAction(){
    }
    
    /**
     * @Route("/", name="_hello_logout")
     * @Template
     */
    public function LogoutAction(){
        
    }
}

?>
