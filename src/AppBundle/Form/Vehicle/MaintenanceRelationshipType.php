<?php

namespace AppBundle\Form\Vehicle;

use AppBundle\Entity\Vehicle\MaintenanceRelationship;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaintenanceRelationshipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maintenanceType', EntityType::class, array(
                'class' => 'AppBundle\Entity\Vehicle\MaintenanceType',
                'choice_label' => 'maintenanceName',
                'empty_data' => null,
                'placeholder' => 'Scegli Tipo Manutenzione',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => MaintenanceRelationship::class
        ));
    }
}