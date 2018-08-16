<?php

namespace AppBundle\Form\Vehicle;

use AppBundle\Entity\Vehicle\CarTax;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarTaxType extends VehiclePeriodicCostType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CarTax::class
        ));
    }
}