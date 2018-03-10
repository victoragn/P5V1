<?php

namespace Agnez\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Agnez\CoreBundle\Form\ClasseType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType //Formulaire retournant l'objet User contentant les diiférentes classes
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('classes',         CollectionType::class,array(
                'entry_type'        => ClasseType::class,
                'label'             => 'Classes',
                'allow_add'         => true,
                'allow_delete'      => true,
                'by_reference'      => false,
            ))
            ->add('Envoyer',      SubmitType::class, array(
                'attr' => array('class' => 'btn btn-success')
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agnez\UserBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'agnez_userbundle_user';
    }


}
