<?php

namespace AppBundle\Form\Vehicle;
use AppBundle\Entity\Vehicle\MaintenanceDetail;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaintenanceDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maintenanceType', EntityType::class, array(
                'class' => 'AppBundle\Entity\Vehicle\MaintenanceType',
                'choice_label' => 'maintenanceName',
                'empty_data' => null,
                'placeholder' => 'Tipo Manutenzione',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('description', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('amount', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('vat', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input int_touch_spin'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => MaintenanceDetail::class
        ));
    }
}