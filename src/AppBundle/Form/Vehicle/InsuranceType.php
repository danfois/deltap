<?php

namespace AppBundle\Form\Vehicle;
use AppBundle\Entity\Vehicle\Insurance;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InsuranceType extends VehiclePeriodicCostType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('company', EntityType::class, array(
                'class' => 'AppBundle:Provider',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->select('p');
                },
                'choice_label' => 'business_name',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('number', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('agent', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('durationType', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'choices' => array(
                    'Mensile' => 1,
                    'Trimestrale' => 3,
                    'Semestrale' => 6,
                    'Annuale' => 12
                ),
                'empty_data' => null
            ))
            ->add('flat', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Insurance::class
        ));
    }
}