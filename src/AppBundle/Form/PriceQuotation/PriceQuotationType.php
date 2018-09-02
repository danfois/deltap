<?php

namespace AppBundle\Form\PriceQuotation;
use AppBundle\Entity\PriceQuotation\PriceQuotation;
use AppBundle\Form\LetterType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceQuotationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer', EntityType::class, array(
                'class' => 'AppBundle:Customer',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')->select('c');
                },
                'choice_label' => 'business_name',
                'placeholder' => 'Scegli Cliente',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input customer_select'
                )
            ))
            ->add('priceQuotationDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('code', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('request', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('contract', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('recipientEmail', EmailType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('senderMail', EmailType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('serviceCode', EntityType::class, array(
                'class' => 'AppBundle:Service',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')->select('s');
                },
                'choice_label' => 'service',
                'placeholder' => 'Scegli Servizio',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input service_select'
                )
            ))
            ->add('letter', LetterType::class)
            ->add('priceQuotationDetails', CollectionType::class, array(
                'entry_type' => EntityType::class,
                'entry_options' => array(
                    'allow_add' => true,
                    'allow_delete' => true,
                    'class' => 'AppBundle\Entity\PriceQuotation\PriceQuotationDetail',
                    'choice_label' => 'name'
                ),
                'allow_add' => true,
                'allow_delete' => true
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PriceQuotation::class
        ));
    }
}