<?php
namespace Agnez\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Agnez\CoreBundle\Form\ClassType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FormulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('classes',         CollectionType::class,array(
                'entry_type'        => ClasseType::class,
                'allow_add'         => true,
                'allow_delete'      => true,
                'by_reference'      => false
            ))
            ->add('ajouter la classe',      SubmitType::class)
        ;
    }
}
