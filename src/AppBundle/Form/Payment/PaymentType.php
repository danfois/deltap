<?php

namespace AppBundle\Form\Payment;

use AppBundle\Entity\Invoice\IssuedInvoice;
use AppBundle\Entity\Payment\BankAccount;
use AppBundle\Entity\Payment\Payment;
use AppBundle\Form\DataTransformer\StringToDateTransformer;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    protected $transformer;

    public function __construct(StringToDateTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('paymentDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('direction', ChoiceType::class, array(
                'choices' => array(
                    'Entrata' => 'IN',
                    'Uscita' => 'OUT'
                ),
                'multiple' => false,
                'empty_data' => null,
                'placeholder' => 'Nessuno',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('paymentType', ChoiceType::class, array(
                'choices' => array(
                    'Contanti' => 'CASH',
                    'Assegno' => 'CHECK',
                    'Bonifico' => 'TRANSFER'
                ),
                'multiple' => false,
                'empty_data' => null,
                'placeholder' => 'Nessuno',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('checkNumber', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('checkDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                ),
                'required' => false
            ))
            ->add('amount', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('causal', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('description', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('customer', EntityType::class, array(
                'class' => 'AppBundle\Entity\Customer',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')->select('c')->orderBy('c.businessName');
                },
                'choice_label' => 'businessName',
                'empty_data' => null,
                'placeholder' => 'Nessuno',
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('provider', EntityType::class, array(
                'class' => 'AppBundle\Entity\Provider',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')->select('c')->orderBy('c.businessName');
                },
                'choice_label' => 'businessName',
                'empty_data' => null,
                'placeholder' => 'Nessuno',
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('employee', EntityType::class, array(
                'class' => 'AppBundle\Entity\Employee\Employee',
                'choice_label' => function($e) {
                    return $e->getName() . ' ' . $e->getSurname();
                },
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')->select('c')->orderBy('c.name');
                },
                'empty_data' => null,
                'placeholder' => 'Scegli Dipendente',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('bankAccount', EntityType::class, array(
                'class' => 'AppBundle\Entity\Payment\BankAccount',
                'choice_label' => function ($obj) {
                    return $obj->getBankName() . ' - ' . $obj->getAccountNumber();
                },
                'empty_data' => null,
                'placeholder' => 'Nessuno',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('issuedInvoice', EntityType::class, array(
                'class' => 'AppBundle\Entity\Invoice\IssuedInvoice',
                'choice_label' => function ($obj) {
                        return $obj->getInvoiceNumber() . ' - ' . $obj->getCustomer()->getBusinessName();
                },
                'empty_data' => null,
                'placeholder' => 'Nessuno',
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('receivedInvoice', EntityType::class, array(
                'class' => 'AppBundle\Entity\Invoice\ReceivedInvoice',
                'choice_label' => function ($obj) {
                    return $obj->getProvider()->getBusinessName() . ' - ' . $obj->getInvoiceNumber();
                },
                'empty_data' => null,
                'placeholder' => 'Nessuno',
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ));

        $builder->get('checkDate')->addModelTransformer($this->transformer);
        $builder->get('paymentDate')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Payment::class
        ));
    }
}