<?php

namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepeatedTimesType extends AbstractType
{
    public $start_time;
    public $end_time;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start_time', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input time_picker'
                )
            ))
            ->add('end_time', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input time_picker'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => RepeatedTimesType::class
        ));
    }
    public function getStartTime() {
        return $this->start_time;
    }
    public function getEndTime() {
        return $this->end_time;
    }
}