<?php

namespace Agnez\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OubliClasseType extends AbstractType //Formulaire de la page d'accueil pour enregistrer les oublis
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options){
        $heure = $options['heure'];
        $nbTypeOublis=$options['nbTypeOublis'];
        $classe=$heure->getClasse();
        $eleves=$classe->getEleves();
        $events=$heure->getEvents();
        for($k=1;$k<=$nbTypeOublis;$k++){//ajoute autant de formulaires que de type d'oublis enregistrés
            foreach($eleves as $eleve){
                $data=false;
                foreach($events as $event){//pour chaque event de l'heure, verifie s'il s'agit de cet élève et de ce type d'event
                    if( $event->getEleve()==$eleve && $event->getType()==$k ){
                        $data=true;
                    }
                }

                $builder->add('oubli'.$k.$eleve->getPlace(), CheckboxType::class, array(
                    'label'    => $eleve->getPrenom().' '.$eleve->getNom(),
                    'required' => false,
                    'data'     => $data
                ));
            }
        }
        $builder->add('save', SubmitType::class, array(
                'attr' => array('class' => 'animated infinite btn btn-success')
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver){
        $resolver->setRequired('heure');
        $resolver->setRequired('nbTypeOublis');
    }

}
