<?php

namespace AppBundle\Form\Vehicle;

use AppBundle\Entity\Vehicle\InsuranceVehicleAssociation;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InsuranceVehicleAssociationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vehicle', EntityType::class, array(
                'class' => 'AppBundle\Entity\Vehicle\Vehicle',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                        ->select('v');
                },
                'choice_label' => 'plate',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('insurance', EntityType::class, array(
                'class' => 'AppBundle\Entity\Vehicle\Insurance',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                        ->select('v');
                },
                'choice_label' => 'plate',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => InsuranceVehicleAssociation::class,
            'csrf_protection' => false
        ));
    }
}