<?php

namespace AppBundle\Form\Vehicle;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaintenanceTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maintenanceName', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('dateInterval', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'choices' => array(
                    'Mensile' => '1 month',
                    'Bimestrale' => '2 months',
                    'Trimestrale' => '3 months',
                    'Quadrimestrale' => '4 months',
                    'Semestrale' => '6 months',
                    'Annuale' => '1 year',
                    'Biennale' => '2 years',
                    'Triennale' => '3 years',
                    'Quadriennale' => '4 years',
                    'Quinquiennale' => '5 years',
                    'Decennale' => '10 years'

                ),
                'empty_data' => null,
                'placeholder' => 'Scegli l\'intervallo',
                'required' => false
            ))
            ->add('kmInterval', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input, int_touch_spin'
                ),
                'required' => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => \AppBundle\Entity\Vehicle\MaintenanceType::class
        ));
    }
}