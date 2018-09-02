<?php

namespace AppBundle\Form\PriceQuotation;
use AppBundle\Entity\PriceQuotation\PriceQuotation;
use AppBundle\Entity\PriceQuotation\PriceQuotationDetail;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SinglePriceQuotationDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('priceQuotationDetailId', EntityType::class, array(
            'class' => 'AppBundle\Entity\PriceQuotation\PriceQuotationDetail',
            'choice_label' => 'name',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('p')->select('p');
            },
            'attr' => array(
                'class' => 'form-control m-input'
            )
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PriceQuotationDetail::class
        ));
    }
}