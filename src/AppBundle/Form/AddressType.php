<?php

namespace AppBundle\Form;
use AppBundle\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('zone', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('cap', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('city', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('country', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('region', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('address', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Address::class
        ));
    }
}