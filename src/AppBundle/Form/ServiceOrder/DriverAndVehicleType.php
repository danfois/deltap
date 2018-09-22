<?php

namespace AppBundle\Form\ServiceOrder;
use AppBundle\Entity\ServiceOrder\ServiceOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DriverAndVehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('driver', EntityType::class, array(
                'class' => 'AppBundle\Entity\User',
                'choice_label' => 'username',
                'placeholder' => 'Nessuno',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('vehicle', EntityType::class, array(
                'class' => 'AppBundle\Entity\Vehicle\Vehicle',
                'choice_label' => 'plate',
                'placeholder' => 'Nessuno',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input'
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