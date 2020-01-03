<?php

namespace AppBundle\Form\Provider;

use AppBundle\Entity\Provider\ProviderRating;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProviderRatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reliability', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input provider-rating'
                )
            ))
            ->add('quality', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input provider-rating'
                )
            ))
            ->add('price', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input provider-rating'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ProviderRating::class
        ));
    }
}