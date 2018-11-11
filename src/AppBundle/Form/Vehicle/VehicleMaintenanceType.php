<?php

namespace AppBundle\Form\Vehicle;
use AppBundle\Entity\Vehicle\Maintenance;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class VehicleMaintenanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vehicle', EntityType::class, array(
                'class' => 'AppBundle\Entity\Vehicle\Vehicle',
                'choice_label' => 'plate',
                'empty_data' => null,
                'placeholder' => 'Scegli un veicolo',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('provider', EntityType::class, array(
                'class' => 'AppBundle\Entity\Provider',
                'choice_label' => 'businessName',
                'empty_data' => null,
                'placeholder' => 'Scegli Fornitore',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('employee', EntityType::class, array(
                'class' => 'AppBundle\Entity\Employee\Employee',
                'choice_label' => function($e) {
                    return $e->getName() . ' ' . $e->getSurname();
                },
                'empty_data' => null,
                'placeholder' => 'Esecutore Interno',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('startKm', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input int_touch_spin'
                )
            ))
            ->add('startDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('maintenanceDetails', CollectionType::class, array(
                'entry_type' => MaintenanceDetailType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'constraints' => array(new Valid()),
                'by_reference' => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Maintenance::class
        ));
    }
}