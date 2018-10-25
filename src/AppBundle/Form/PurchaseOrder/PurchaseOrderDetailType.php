<?php

namespace AppBundle\Form\PurchaseOrder;
use AppBundle\Entity\PurchaseOrder\PurchaseOrderDetail;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PurchaseOrderDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input int_touch_spin'
                )
            ))
            ->add('description', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('vehicle', EntityType::class, array(
                'class' => 'AppBundle\Entity\Vehicle\Vehicle',
                'choice_label' => 'plate',
                'empty_data' => null,
                'placeholder' => 'Scegli Veicolo',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PurchaseOrderDetail::class
        ));
    }
}