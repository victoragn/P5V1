<?php

namespace Agnez\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Agnez\CoreBundle\Form\ClasseType;
use Agnez\CoreBundle\Form\FormulaireType;
use Agnez\UserBundle\Form\UserType;
use Agnez\CoreBundle\Entity\Classe;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        $user = $this->getUser();
        $originalClasses = new ArrayCollection();
        foreach ($user->getClasses() as $classe) {
            $originalClasses->add($classe);
        }
        $form=$this->createForm(UserType::class,$user);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                foreach ($originalClasses as $classe) {
                    if (false === $user->getClasses()->contains($classe)) {
                        $em->remove($classe);
                    }
                }

                $em->persist($user);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'User bien enregistré.');
            }
        }
        return $this->render('@AgnezCore/Classes/classes.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/classes/edit", name="agnez_core_editClasses")
     */
    /*public function editClasseAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();



            $em->persist($user);
            $em->flush();

            // redirect back to some edit page
            return $this->redirectToRoute('agnez_core_classes');
        }

        // render some form template
    }*/

}
