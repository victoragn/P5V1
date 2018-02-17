<?php

namespace Agnez\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Agnez\CoreBundle\Form\ClasseType;
use Agnez\CoreBundle\Entity\Classe;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use DateTime;
use DatePeriod;
use DateInterval;

class DefaultController extends Controller{
     /**
     * @Route("/", name="agnez_core_homepage")
     */
    public function indexAction(){
        $securityContext = $this->container->get('security.authorization_checker');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('fos_user_security_login');
        }else{
            $date=new \DateTime('2017-09-07 16:05:00');

            $servicedate = $this->container->get('agnez_core.servicedate');
            $numSem=$servicedate->numSem($date);
            $numHeure=$servicedate->numHeure($date);

            return $this->render('@AgnezCore/Default/index.html.twig', array('numSem' => $numSem, 'numHeure' => $numHeure ));
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
        $form = $this->createForm(ClasseType::class,$classe);
        /*foreach($classes as $classe){
        $form->add()
        }*/
        $form->add('save', SubmitType::class);

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
