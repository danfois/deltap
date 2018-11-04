<?php

namespace AppBundle\Form\Employee;

use AppBundle\Entity\Employee\EmployeeUnavailability;
use AppBundle\Form\DataTransformer\StringToDateTransformer;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeUnavailabilityType extends AbstractType
{
    protected $transformer;

    public function __construct(StringToDateTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('employee', EntityType::class, array(
                'class' => 'AppBundle\Entity\Employee\Employee',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                        ->select('v');
                },
                'choice_label' => function($e) {
                    return $e->getName() . ' ' . $e->getSurname();
                },
                'empty_data' => null,
                'placeholder' => 'Scegli dipendente',
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
            ))
            ->add('issue', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ));

        $builder->get('startDate')->addModelTransformer($this->transformer);
        $builder->get('endDate')->addModelTransformer($this->transformer);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => EmployeeUnavailability::class
        ));
    }
}