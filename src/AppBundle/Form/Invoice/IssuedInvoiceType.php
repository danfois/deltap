<?php

namespace AppBundle\Form\Invoice;

use AppBundle\Entity\Invoice\IssuedInvoice;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class IssuedInvoiceType extends InvoiceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('priceQuotation', EntityType::class, array(
                'class' => 'AppBundle\Entity\PriceQuotation\PriceQuotation',
                'choice_label' => 'code',
                'empty_data' => null,
                'placeholder' => 'Scegli il Preventivo',
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('invoiceDetails', CollectionType::class, array(
                'entry_type' => InvoiceDetailType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'constraints' => array(new Valid()),
                'by_reference' => false
            ))
            ->add('customer', EntityType::class, array(
                'class' => 'AppBundle\Entity\Customer',
                'choice_label' => 'businessName',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'placeholder' => 'Scegli Cliente',
                'required' => true
            ))
            ->add('isProforma', CheckboxType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input',
                    'data-switch' => 'true',
                    'data-on-color' => 'success',
                    'data-off-color' => 'metal',
                    'data-on-text' => 'Si',
                    'data-off-text' => 'No'
                ),
                'required' => false
            ))
            ->add('proformaNumber', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input int_touch_spin'
                ),
                'required' => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => IssuedInvoice::class
        ));
    }
}