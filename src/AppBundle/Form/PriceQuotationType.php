<?php

namespace AppBundle\Form;
use AppBundle\Entity\PriceQuotation;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceQuotationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quotation_date', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('quotation_code', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('customer', EntityType::class, array(
                'class' => 'AppBundle:Customer',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')->select('c');
                },
                'choice_label' => 'business_name',
                'placeholder' => 'Scegli Cliente',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('request', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('contract', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('email', EmailType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('pec', EmailType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('status', NumberType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('service_code', EntityType::class, array(
                'class' => 'AppBundle:Service',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')->select('s');
                },
                'choice_label' => 'service',
                'placeholder' => 'Scegli Servizio',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('letter', LetterType::class)
            ->add('quotationDetails', CollectionType::class, array(
                'entry_type' => PriceQuotationDetailType::class
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PriceQuotation::class
        ));
    }
}