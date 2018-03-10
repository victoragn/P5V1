<?php

namespace Agnez\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Agnez\CoreBundle\Form\EleveType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class Classe2Type extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eleves',         CollectionType::class,array(
                'entry_type'        => EleveType::class,
                'label'             => 'Elèves enregistrés',
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
            'data_class' => 'Agnez\CoreBundle\Entity\Classe'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'agnez_userbundle_classe';
    }


}
