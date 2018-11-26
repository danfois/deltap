<?php

namespace AppBundle\Form\Employee;

use AppBundle\Entity\Employee\EmployeeTurnDetail;
use AppBundle\Form\DataTransformer\StringToTimeTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeTurnDetailType extends AbstractType
{
    protected $transformer;

    public function __construct(StringToTimeTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startTime', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input time_picker'
                ),
                'required' => false
            ))
            ->add('endTime', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input time_picker'
                ),
                'required' => false
            ))
            ->add('employee', EntityType::class, array(
                'class' => 'AppBundle\Entity\Employee\Employee',
                'choice_label' => function($e) {
                    return $e->getName() . ' ' . $e->getSurname();
                },
                'attr' => array(
                    'class' => 'd-none'
                )
            ))
            ->add('workingHours', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input time_picker'
                ),
                'required' => false
            ))
            ->add('illness', CheckboxType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('holiday', CheckboxType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('permissionTime', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input time_picker'
                ),
                'required' => false
            ));

        $builder->get('startTime')->addModelTransformer($this->transformer);
        $builder->get('endTime')->addModelTransformer($this->transformer);
        $builder->get('workingHours')->addModelTransformer($this->transformer);
        $builder->get('permissionTime')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => EmployeeTurnDetail::class
        ));
    }
}