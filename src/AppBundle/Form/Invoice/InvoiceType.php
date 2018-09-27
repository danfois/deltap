<?php

namespace AppBundle\Form\Invoice;

use AppBundle\Entity\Invoice\Invoice;
use AppBundle\Form\DataTransformer\StringToDateTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceType extends AbstractType
{
    protected $transformer;

    public function __construct(StringToDateTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('invoiceDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('invoiceNumber', NumberType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input int_touch_spin'
                )
            ))
            ->add('causal', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('paymentTerms', ChoiceType::class, array(
                'choices' => array(
                    'Contanti' => 'Contanti',
                    'Assegno' => 'Assegno',
                    'Bonifico' => 'Bonifico',
                    'RID' => 'RID'
                ),
                'empty_data' => null,
                'placeholder' => 'Scegli il metodo di pagamento',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('paInvoice', RadioType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('paInvoiceNumber', NumberType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input int_touch_spin'
                ),
                'required' => false
            ))
            ->add('pa_receipt_date', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                ),
                'required' => false
            ))
            ->add('customer', EntityType::class, array(
                'class' => 'AppBundle\Entity\Customer',
                'choice_label' => 'businessName',
                'empty_data' => null,
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
                )
            ));

        $builder->get('invoiceDate')->addModelTransformer($this->transformer);
        $builder->get('pa_receipt_date')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Invoice::class
        ));
    }
}