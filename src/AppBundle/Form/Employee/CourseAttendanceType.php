<?php

namespace AppBundle\Form\Employee;

use AppBundle\Entity\Employee\CourseAttendance;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseAttendanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('course', EntityType::class, array(
                'class' => 'AppBundle\Entity\Employee\Course',
                'choice_label' => 'name',
                'empty_data' => null,
                'placeholder' => 'Scegli Corso',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CourseAttendance::class
        ));
    }
}