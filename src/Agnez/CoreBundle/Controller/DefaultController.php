<?php

namespace Agnez\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Agnez\CoreBundle\Form\ClasseType;
use Agnez\CoreBundle\Entity\Classe;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
    public function gestionClassesAction(Request $request){
        $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('AgnezCoreBundle:Classe');
        $classes=$repository->findByUser( $this->getUser() );
        $classe= $classes[0];
        /*$classe->setUser( $this->getUser() );*/
        $form = $this
            ->createForm(ClasseType::class,$classe)
            ->add('save', SubmitType::class);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($classe);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Classe bien enregistrée.');
            }
        }
        return $this->render('@AgnezCore/Classes/classes.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
