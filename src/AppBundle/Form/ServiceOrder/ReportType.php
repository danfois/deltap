<?php

namespace AppBundle\Form\ServiceOrder;
use AppBundle\Entity\ServiceOrder\Report;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('serviceOrder', EntityType::class, array(
                'class' => 'AppBundle\Entity\ServiceOrder\ServiceOrder',
                'choice_label' => 'serviceOrder',
                'attr' => array(
                    'class' => 'hidden'
                )
            ))
            ->add('startKm', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('endKm', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('totalKm', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input',
                    'readonly' => 'readonly'
                )
            ))
            ->add('fuelCost', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('fuelLt', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('oilCost', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('oilLt', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('notes', TextareaType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input summernote'
                ),
                'required' => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Report::class
        ));
    }
}