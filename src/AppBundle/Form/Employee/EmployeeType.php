<?php

namespace AppBundle\Form\Employee;
use AppBundle\Entity\Employee\Employee;
use AppBundle\Form\PersonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends PersonType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('employeeCode', TextType::class, array(
                'attr' => array(
                    'class' => 'm-input form-control'
                )
            ))
            ->add('employmentType', ChoiceType::class, array(
                'choices' => array(
                    'Fisso' => 1,
                    'Occasionale' => 2
                ),
                'attr' => array(
                    'class' => 'm-input form-control'
                )
            ))
            ->add('admission', TextType::class, array(
                'attr' => array(
                    'class' => 'm-input form-control date_picker'
                )
            ))
            ->add('payGrade', TextType::class, array(
                'attr' => array(
                    'class' => 'm-input form-control'
                )
            ))
            ->add('duties', TextareaType::class, array(
                'attr' => array(
                    'class' => 'm-input form-control'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults(array(
           'data_class' => Employee::class
       ));
    }
}