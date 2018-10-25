<?php

namespace AppBundle\Form\PurchaseOrder;
use AppBundle\Entity\PurchaseOrder\PurchaseOrder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class PurchaseOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('provider', EntityType::class, array(
                'class' => 'AppBundle\Entity\Provider',
                'choice_label' => 'businessName',
                'empty_data' => null,
                'placeholder' => 'Scegli Fornitore',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('referencePerson', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('employee', EntityType::class, array(
                'class' => 'AppBundle\Entity\Employee\Employee',
                'choice_label' => function($employee) {
                    return $employee->getName() . ' ' . $employee->getSurname();
                },
                'empty_data' => 'null',
                'placeholder' => 'Scegli Dipendente',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('orderDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('expirationDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('orderNotes', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('footerNotes', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('paymentTerms', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('deliveryPlace', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('referent', EntityType::class, array(
                'class' => 'AppBundle\Entity\Employee\Employee',
                'choice_label' => function ($employee) {
                    return $employee->getName() . ' ' . $employee->getSurname();
                },
                'empty_data' => null,
                'placeholder' => 'Scegli Referente',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('purchaseOrderDetails', CollectionType::class, array(
                'entry_type' => PurchaseOrderDetailType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'constraints' => array(new Valid()),
                'by_reference' => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PurchaseOrder::class
        ));
    }
}