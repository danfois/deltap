<?php

namespace AppBundle\Form\Vehicle;

use AppBundle\Entity\Vehicle\InsuranceSuspension;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InsuranceSuspensionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('insurance', EntityType::class, array(
                'class' => 'AppBundle\Entity\Vehicle\Insurance',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->select('i');
                },
                'choice_label' => 'insuranceId',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('startDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('endDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => InsuranceSuspension::class
        ));
    }
}