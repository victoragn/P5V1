<?php

namespace Agnez\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Agnez\CoreBundle\Form\ClasseType;
use Agnez\CoreBundle\Form\Classe2Type;
use Agnez\CoreBundle\Form\OubliClasseType;
use Agnez\UserBundle\Form\UserType;
use Agnez\UserBundle\Form\User2Type;
use Agnez\CoreBundle\Entity\Classe;
use Agnez\CoreBundle\Entity\Event;
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
     * @Route("/{sem}/{numHeure}", name="agnez_core_homepage", requirements={"sem"="\d+","numHeure"="\d+"})
     */
    public function indexAction(Request $request, $sem=0, $numHeure=0){
        $tabTypeOublis=['Cahier','Règle','Compas','Exercice','Carnet','Rapporteur'];
        $nbTypeOublis=6;

        $securityContext = $this->container->get('security.authorization_checker');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('fos_user_security_login');
        }else{

            if($this->getUser()->getInitialized()==0){// si le user n'a pas initialisé une premiere fois va vers la page de creation des classes
                return $this->redirectToRoute('agnez_core_initClasses');
            }
            if($this->getUser()->getInitialized()==1){// si le user a deja init les classes il va vers la page de choix des classes
                return $this->redirectToRoute('agnez_core_choixClasse');
            }
            if($this->getUser()->getInitialized()==2){// si le user a deja init les classes il va vers la page de choix des classes
                return $this->redirectToRoute('agnez_core_edt');
            }
            if($this->getUser()->getInitialized()==3){// si le user a deja init les classes il va vers la page de choix des classes
                return $this->redirectToRoute('agnez_core_validInitEdt');
            }

            $servicedate = $this->container->get('agnez_core.servicedate');
            $message='';

            if ($sem==0){//si la semaine n'est pas définie, envoie sur la semaine actuelle
                $sem=$servicedate->numSem(new DateTime());
                return $this->redirectToRoute('agnez_core_homepage',array('sem'=>$sem));
            }else{//sinon verifie l'authentification
                $tabEnteteSem=$servicedate->getDateSem($sem);
                $servicegetSem = $this->container->get('agnez_core.servicegetSem');
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('AgnezCoreBundle:EdtHeure');

                $listeHeuresSem=$servicegetSem->getSem($this->getUser(),$sem,$repository);

                if($numHeure!=0){/*Si une heure est selectionnée*/
                    foreach($listeHeuresSem as $heure){/*Trouve l'heure avec son id et l'enregistre dans heureSelec*/
                        if($heure->getId()==$numHeure){
                            $heureSelec=$heure;
                        }
                    }
                    if(isset($heureSelec)){
                        $events=$heureSelec->getEvents();
                        $eleves=$heureSelec->getClasse()->getEleves();

                        if(count($eleves)==0){
                            $message=$message.'Veuillez remplir des élèves pour cette classe !';
                        }else{
                            $form=$this->createFormBuilder()
                                ->add('tabOubliClasse', OubliClasseType::class,array('heure' =>$heureSelec,'nbTypeOublis' =>$nbTypeOublis))
                                ->getForm();

                            if ($request->isMethod('POST')) {
                                $form->handleRequest($request);
                                if ($form->isValid()) {
                                    $data=$form->getData()['tabOubliClasse'];//recuperation des infos des formulaires pour chaque type d'oubli

                                    for ($k=1;$k<=$nbTypeOublis;$k++){
                                        for ($i=1;$i<=count($data)/$nbTypeOublis;$i++){
                                            foreach($eleves as $eleve){
                                                if($eleve->getPlace()==$i){
                                                    $eleveTemp=$eleve;//Trouve l'eleve i et l'enregistre dans eleveTemp
                                                }
                                                $em = $this->getDoctrine()->getManager();
                                            }
                                            if($data['oubli'.$k.$i]==false){
                                                foreach($events as $event){
                                                    if($event->getEdtHeure()==$heureSelec && $event->getEleve()==$eleveTemp && $event->getType()==$k){
                                                        $em->remove($event);
                                                    }
                                                }
                                            }
                                            if($data['oubli'.$k.$i]==true){
                                                $eventPresent=0;
                                                foreach($events as $event){
                                                    if($event->getEdtHeure()==$heureSelec && $event->getEleve()==$eleveTemp && $event->getType()==$k){
                                                        $eventPresent++;
                                                    }
                                                }
                                                if($eventPresent==0){
                                                    $nouvEvent=new Event();
                                                    $nouvEvent->setEdtHeure($heureSelec);
                                                    $nouvEvent->setEleve($eleveTemp);
                                                    $nouvEvent->setType($k);
                                                    $em->persist($nouvEvent);

                                                }
                                            }
                                            $em->flush();
                                        }
                                    }
                                }
                            }
                            return $this->render('@AgnezCore/Default/index.html.twig', array(
                                'listeHeures'   => $listeHeuresSem,
                                'numSem'        => $sem,
                                'form'          => $form->createView(),
                                'heureSelec'    => $heureSelec,
                                'tabEnteteSem'  => $tabEnteteSem,
                                'message'       => $message,
                                'tabTypeOublis' => $tabTypeOublis,
                                'nbTypeOublis'  => $nbTypeOublis
                            ));
                        }
                    }
                }
                return $this->render('@AgnezCore/Default/index.html.twig', array(
                    'listeHeures'   => $listeHeuresSem,
                    'numSem'        => $sem,
                    'message'       => 'Sélectionnez une heure de la semaine',
                    'tabEnteteSem'  => $tabEnteteSem,
                    'message'       => $message,
                    'tabTypeOublis' => $tabTypeOublis,
                    'nbTypeOublis'  => $nbTypeOublis
                ));
            }
        }
    }

    /**
     * @Route("/param", name="agnez_core_param")
     */
    public function paramAction(){//page d'accueil des parametres
        $securityContext = $this->container->get('security.authorization_checker');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('fos_user_security_login');
        }else{
            return $this->render('@AgnezCore/Param/param.html.twig');
        }
    }


     /**
     * @Route("/initClasses", name="agnez_core_initClasses")
     */
    public function initClassesAction(Request $request){//page d'ajouts et de suppression des classes de User
        $securityContext = $this->container->get('security.authorization_checker');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('fos_user_security_login');
        }else{

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
                    if($user->getInitialized()!=4){/*si le compte n'a jamais été initialisé jusqu'au bout*/
                        $user->setInitialized(1);
                    }
                    $em->persist($user);
                    $em->flush();
                    return $this->redirectToRoute('agnez_core_choixClasse');

                }
            }
            return $this->render('@AgnezCore/Param/classes.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * @Route("/classes", name="agnez_core_choixClasse")
     */
    public function choixClasseAction(){//page de choix des classes pour y entrer les élèves
        $securityContext = $this->container->get('security.authorization_checker');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('fos_user_security_login');
        }else{

            $user = $this->getUser();
            $classes=$user->getClasses();
            return $this->render('@AgnezCore/Param/choixClasse.html.twig', array(
                'classes' => $classes,
            ));
        }
    }

    /**
     * @Route("/classes/{id}", name="agnez_core_classeDetail")
     */
    public function gestionClassesDetailAction(Request $request, $id){//formulaire d'ajout d'élèves à une classe
        $securityContext = $this->container->get('security.authorization_checker');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('fos_user_security_login');
        }else{

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
                        if (false === $classeActuelle->getEleves()->contains($eleve)) {//si un eleve a été supprimé
                            $repository = $this
                              ->getDoctrine()
                              ->getManager()
                              ->getRepository('AgnezCoreBundle:Event')
                            ;
                            $listEvents=$repository->findByEleve($eleve->getId() );
                            foreach($listEvents as $event){//supprime les events de cet élève
                                $em->remove($event);
                            }
                            $em->remove($eleve);// suprimme l'élève
                        }
                    }

                    $em->persist($classeActuelle);
                    $em->flush();

                    return $this->redirectToRoute('agnez_core_choixClasse');
                }
            }

            return $this->render('@AgnezCore/Param/classesDetail.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * @Route("/validClasses", name="agnez_core_validClasses")
     */
    public function validClassesAction(){//augmente Initialized de User s'il a valider les classes et les eleves
        $securityContext = $this->container->get('security.authorization_checker');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('fos_user_security_login');
        }else{
            $user=$this->getUser();
            if($user->getInitialized()!=4){/*si le compte n'a jamais été initialisé jusqu'au bout*/
                        $user->setInitialized(2);
                    }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('agnez_core_edt');
        }
    }


    /**
     * @Route("/edt", name="agnez_core_edt")
     */
    public function gestionEdtAction(Request $request){//form pour enregistrer l'edt hebdo qui sera utilisé pour initialisé l'année
        $securityContext = $this->container->get('security.authorization_checker');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('fos_user_security_login');
        }else{

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
                    if($user->getInitialized()!=4){/*si le compte n'a jamais été initialisé jusqu'au bout*/
                        $user->setInitialized(3);
                    }
                    $em = $this->getDoctrine()->getManager();

                    $em->persist($user);
                    $em->flush();

                    return $this->redirectToRoute('agnez_core_validInitEdt');

                }
            }


            return $this->render('@AgnezCore/Param/edt.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

     /**
     * @Route("/edt/validInit", name="agnez_core_validInitEdt")
     */
    public function validInitEdtAction(Request $request){//page de demande de validation avant d'initialiser l'année
        $securityContext = $this->container->get('security.authorization_checker');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('fos_user_security_login');
        }else{
            return $this->render('@AgnezCore/Param/validInitEdt.html.twig');
        }
    }

    /**
     * @Route("/edt/init", name="agnez_core_edt_init")
     */
    public function initEdtAction(Request $request){//initialisation de l'année
        $securityContext = $this->container->get('security.authorization_checker');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('fos_user_security_login');
        }else{

            $user = $this->getUser();
            $classes=$user->getClasses();
            $hebdoEDT=$user->getHebdoEDT();

            /*Supprime les anciennes heures*/
            $em = $this->getDoctrine()->getManager();
            $repository = $this
              ->getDoctrine()
              ->getManager()
              ->getRepository('AgnezCoreBundle:EdtHeure')
            ;
            foreach ($classes as $classe){
                $id=$classe->getId();
                $listHeures = $repository->findBy( array('classe' => $id) );
                foreach($listHeures as $heure){
                    $em->remove($heure);
                    $em->flush();
                }
            }

            /*Ajout des nouvelles heures*/
            $serviceinit = $this->container->get('agnez_core.serviceinitEdt');
            $listeHeures=$serviceinit->setNewHeures( $this->getUser() );
            foreach($listeHeures as $heure){
                $em->persist($heure);
            }
            $user->setInitialized(4);
            $em->persist($user);
            $em->flush();


            return $this->redirectToRoute('agnez_core_homepage');
        }
    }



}
