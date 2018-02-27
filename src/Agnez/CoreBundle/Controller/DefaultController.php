<?php

namespace Agnez\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Agnez\CoreBundle\Form\ClasseType;
use Agnez\CoreBundle\Form\Classe2Type;
use Agnez\UserBundle\Form\UserType;
use Agnez\UserBundle\Form\User2Type;
use Agnez\CoreBundle\Entity\Classe;
use Agnez\CoreBundle\Entity\EdtHeure;
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
            $servicedate = $this->container->get('agnez_core.servicedate');

            $date=new \DateTime('2017-12-05 15:00:00');//différents tests
            $numSem=$servicedate->numSem($date);
            $numHeure=$servicedate->numHeure($date);
            $test=$servicedate->getTimeByNumHeure(43);

            /*$edtHeure= new EdtHeure($servicedate);
            $edtHeure->setDateDebut(new \DateTime('2017-12-05 15:00:00'));*/


            return $this->render('@AgnezCore/Default/index.html.twig', array('numSem' => $numSem, 'numHeure' => $numHeure , 'test' => $test ));
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
     * @Route("/eleves", name="agnez_core_eleves")
     */
    public function gestionElevesAction(){
        $user = $this->getUser();
        $classes=$user->getClasses();
        $nomClasses=array();
        foreach($classes as $classe){
            $nomClasses[]=$classe->getName();
        }
        return $this->render('@AgnezCore/Eleves/eleves.html.twig', array(
            'nomClasses' => $nomClasses,
        ));
    }

    /**
     * @Route("/classes/{id}", name="agnez_core_classeDetail")
     */
    public function gestionClassesDetailAction(Request $request, $id){
        $user = $this->getUser();
        $classes=$user->getClasses();
        $nbClasses=$classes->count();
        for ($i=0;$i<$nbClasses;$i++){
            if($classes[$i]->getName()===$id){
                $nbClasseActuelle=$i;
                $classeActuelle=$classes[$i];
            }
        }

        $originalEleves = new ArrayCollection();
        foreach ($classeActuelle->getEleves() as $eleve) {
            $originalEleves->add($eleve);
        }

        $form=$this->createForm(Classe2Type::class,$classeActuelle);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                foreach ($originalEleves as $eleve) {
                    if (false === $classeActuelle->getEleves()->contains($eleve)) {
                        $em->remove($eleve);
                    }
                }

                $em->persist($classeActuelle);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Classe bien enregistrée.');
            }
        }

        return $this->render('@AgnezCore/Classes/ClassesDetail.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/edt", name="agnez_core_edt")
     */
    public function gestionEdtAction(Request $request){
        $user = $this->getUser();
        $classes=$user->getClasses();
        $hebdoEDT=array();
        if( !empty($user->getHebdoEDT()) ){
            $hebdoEDT=$user->getHebdoEDT();
        }
        $form=$this->createFormBuilder()
            ->add('hebdoEdt', User2Type::class,array('current_user' => $user))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data=$form->getData();
                $user->setHebdoEDT($data);
                $em = $this->getDoctrine()->getManager();

                $em->persist($user);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'EDT bien enregistré.');
            }
        }


        return $this->render('@AgnezCore/Edt/edt.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/edt/init", name="agnez_core_edt_init")
     */
    public function initEdtAction(Request $request){
        $user = $this->getUser();
        $classes=$user->getClasses();
        $hebdoEDT=$user->getHebdoEDT();
    }



}
