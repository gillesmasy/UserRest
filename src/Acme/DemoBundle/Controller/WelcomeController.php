<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class WelcomeController extends Controller
{
    /**
     * @Template
     */
    public function indexAction()
    {
        /*
         * The action's view can be rendered using render() method
         * or @Template annotation as demonstrated in DemoController.
         *
         */
        //return $this->render('AcmeDemoBundle:Welcome:index.html.twig');
        return array();
    }
}
