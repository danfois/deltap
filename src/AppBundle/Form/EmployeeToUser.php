<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeToUser extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('employee', EntityType::class, array(
            'class' => 'AppBundle\Entity\Employee\Employee',
            'choice_label' => function($e) {
                return $e->getName() . ' ' . $e->getSurname();
            },
            'empty_data' => null,
            'placeholder' => 'Scegli Dipendente',
            'attr' => array(
                'class' => 'form-control m-input'
            ),
            'required' => true
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }
}