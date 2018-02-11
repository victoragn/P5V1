<?php

namespace Agnez\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller{
     /**
     * @Route("/", name="agnez_core_homepage")
     */
    public function indexAction(){
        $securityContext = $this->container->get('security.authorization_checker');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('fos_user_security_login');
        }else{
            return $this->render('@AgnezCore/Default/index.html.twig');
        }

    }

     /**
     * @Route("/classes", name="agnez_core_classes")
     */
    public function gestionClassesAction(){
        return $this->render('@AgnezCore/Default/classes.html.twig');
    }
}
