<?php

namespace AppBundle\Form\Invoice;

use AppBundle\Entity\Invoice\ReceivedInvoice;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class ReceivedInvoiceType extends InvoiceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('invoiceDetails', CollectionType::class, array(
                'entry_type' => InvoiceDetailType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'constraints' => array(new Valid())
            ))
            ->add('invoiceNumber', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('provider', EntityType::class, array(
                'class' => 'AppBundle\Entity\Provider',
                'choice_label' => 'businessName',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'placeholder' => 'Scegli Fornitore',
                'required' => true
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ReceivedInvoice::class
        ));
    }
}