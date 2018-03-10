<?php

namespace Agnez\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class User2Type extends AbstractType  //Formulaire retournant l'objet User contentant le tableau hebdoEdt dans lequel se trouve l'emploi du temps hebdomadaire du User
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['current_user'];
        $edt=$user->getHebdoEDT()['hebdoEdt'];

        $classes=$user->getClasses();
        $nomClasses= array();
        $nomClasses['vide']=0;
        foreach($classes as $classe){
            $nomClasses[$classe->getName()]=$classe->getName();
        }


        for($j=1;$j<6;$j++){
            for($i=1;$i<9;$i++){
                $valClasse=$edt[$j*10+$i];
                $builder
                    ->add($j.$i, ChoiceType::class,array(
                        'choices'  => $nomClasses,
                        // *this line is important*
                        'choices_as_values' => true,
                        'data' => $valClasse,
                    ));
            }
        }
        $builder->add('save',      SubmitType::class, array(
                'attr' => array('class' => 'btn btn-success')
        ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('current_user');
    }
}
