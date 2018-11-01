<?php

namespace AppBundle\Form\Salary;

use AppBundle\Entity\Salary\Salary;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class SalaryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $yearsArray = array();

        for($i = 2000; $i <= 2020; $i++ ) {
            $yearsArray[$i] = $i;
        }

        $builder
            ->add('employee', EntityType::class, array(
                'class' => 'AppBundle\Entity\Employee\Employee',
                'choice_label' => function ($e) {
                    return $e->getName() . ' ' . $e->getSurname();
                },
                'empty_data' => null,
                'placeholder' => 'Scegli Dipendente',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('year', ChoiceType::class, array(
                'choices' => $yearsArray,
                'empty_data' => null,
                'placeholder' => 'Anno',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('month', ChoiceType::class, array(
                'choices' => array(
                    '01' => '01',
                    '02' => '02',
                    '03' => '03',
                    '04' => '04',
                    '05' => '05',
                    '06' => '06',
                    '07' => '07',
                    '08' => '08',
                    '09' => '09',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12',
                ),
                'empty_data' => null,
                'placeholder' => 'Mese',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('amount', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('causal', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('salaryDetails', CollectionType::class, array(
                'entry_type' => SalaryDetailType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'constraints' => array(new Valid()),
                'by_reference' => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Salary::class
        ));
    }
}