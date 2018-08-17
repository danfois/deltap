<?php

namespace AppBundle\Form\Vehicle;

use AppBundle\Entity\Vehicle\CarReview;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarReviewType extends VehiclePeriodicCostType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CarReview::class
        ));
    }
}