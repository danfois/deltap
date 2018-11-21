<?php

namespace AppBundle\Form\ServiceOrder;

use AppBundle\Entity\ServiceOrder\ServiceOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProblemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('problems', TextareaType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input summernote'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ServiceOrder::class
        ));
    }
}