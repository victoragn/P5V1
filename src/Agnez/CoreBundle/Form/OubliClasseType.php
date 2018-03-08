<?php

namespace Agnez\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OubliClasseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options){
        $heure = $options['heure'];
        $classe=$heure->getClasse();
        $eleves=$classe->getEleves();
        foreach($eleves as $eleve){
            $data=false;
            $eventsEleve=$eleve->getEvents();
            foreach($eventsEleve as $event){
                if($event->getEdtHeure()==$heure){
                    $data=true;
                }
            }

            $builder->add('oubli'.$eleve->getPlace(), CheckboxType::class, array(
                'label'    => $eleve->getPrenom().' '.$eleve->getNom(),
                'required' => false,
                'data'     => $data
            ));
        }
        $builder->add('save', SubmitType::class, array(
                'attr' => array('class' => 'animated infinite btn btn-success btnSansLien')
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver){
        $resolver->setRequired('heure');
    }

}
