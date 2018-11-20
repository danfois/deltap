<?php

namespace AppBundle\Form\PriceQuotation;

use AppBundle\Entity\PriceQuotation\Attachment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttachmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('file', FileType::class, array(
        'attr' => array(
            'class' => 'form-control m-input',
        ),
        'required' => false
    ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Attachment::class
        ));
    }
}