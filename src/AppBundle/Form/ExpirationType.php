<?php

namespace AppBundle\Form;

use AppBundle\Entity\Expiration;
use AppBundle\Form\DataTransformer\StringToDateTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpirationType extends AbstractType
{
    protected $transformer;

    public function __construct(StringToDateTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('description', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('expirationDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('issuedInvoice', EntityType::class, array(
                'class' => 'AppBundle\Entity\Invoice\IssuedInvoice',
                'choice_label' => function($o) {
                    return "Id " . $o->getInvoiceId() . "; n. " . $o->getInvoiceNumber() . "; Cliente " . $o->getCustomer()->getBusinessName();
                },
                'empty_data' => null,
                'placeholder' => 'Nessuna',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('receivedInvoice', EntityType::class, array(
                'class' => 'AppBundle\Entity\Invoice\ReceivedInvoice',
                'choice_label' => function($o) {
                    return "Id " . $o->getInvoiceId() . "; n. " . $o->getInvoiceNumber() . "; Forn. " . $o->getProvider()->getBusinessName();
                },
                'empty_data' => null,
                'placeholder' => 'Nessuna',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ));
        $builder->get('expirationDate')->addModelTransformer($this->transformer);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Expiration::class
        ));
    }
}