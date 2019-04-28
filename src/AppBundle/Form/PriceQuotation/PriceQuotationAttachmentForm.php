<?php

namespace AppBundle\Form\PriceQuotation;

use AppBundle\Entity\PriceQuotation\PriceQuotationAttachment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceQuotationAttachmentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('financialFlow', FileType::class, array('data_class' => null))
            ->add('questionary', FileType::class, array('data_class' => null))
            ->add('responsibilityDeclaration', FileType::class, array('data_class' => null));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PriceQuotationAttachment::class
        ));
    }
}