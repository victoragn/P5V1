<?php

namespace Agnez\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class User3Type extends AbstractType  //Formulaire retournant la liste des oublis souhaités par l'utilisateur
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['current_user'];
        $oublis=$user->getlisteOublis()['listeOublis'];

        for($i=0;$i<10;$i++){
                $valOublis=$oublis[$i];
                $builder
                    ->add($i, TextType::class,array(
                        'required'   => false,
                        'label_format' => $i,
                         ));
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
