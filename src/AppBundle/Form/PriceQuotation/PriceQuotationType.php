<?php

namespace AppBundle\Form\PriceQuotation;
use AppBundle\Entity\PriceQuotation\PriceQuotation;
use AppBundle\Entity\PriceQuotation\PriceQuotationDetail;
use AppBundle\Form\DataTransformer\StringToDateTransformer;
use AppBundle\Form\LetterType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceQuotationType extends AbstractType
{

    protected $transformer;

    public function __construct(StringToDateTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer', EntityType::class, array(
                'class' => 'AppBundle:Customer',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')->select('c');
                },
                'choice_label' => 'business_name',
                'placeholder' => 'Scegli Cliente',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input customer_select'
                )
            ))
            ->add('priceQuotationDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('code', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('request', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('contract', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('recipientEmail', EmailType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('senderMail', EmailType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('serviceCode', EntityType::class, array(
                'class' => 'AppBundle:Service',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')->select('s');
                },
                'choice_label' => 'service',
                'placeholder' => 'Scegli Servizio',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input service_select'
                )
            ))
            ->add('letter', LetterType::class, array(
                'required' => false
            ))
            ->add('priceQuotationDetails', CollectionType::class, array(
                'entry_type' => EntityType::class,
                'by_reference' => false,
                'entry_options' => array(
                    'class' => 'AppBundle\Entity\PriceQuotation\PriceQuotationDetail',
                    //'choice_label' => 'name',
                    'choice_label' => function($pqd) {
                        $departureLocation = '';
                        $arrivalLocation = '';

                        foreach($pqd->getStages() as $s) {
                            $departureLocation .= $s->getDepartureLocation() . ',';
                            $arrivalLocation .= $s->getArrivalLocation(). ',';
                        }
                        return $pqd->getName() . ' ' . $departureLocation . ' - ' . $arrivalLocation;
                    },
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('p')->select('p');
                    },
                    'attr' => array(
                        'class' => 'form-control m-input'
                    ),
                    'empty_data' => null,
                    'placeholder' => 'Nessuno',
                    'required' => false
                ),
                'allow_add' => true,
                'allow_delete' => true,
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            /*->add('priceQuotationDetails', CollectionType::class, array(
                'entry_type' => SinglePriceQuotationDetailType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))*/;

            $builder->get('priceQuotationDate')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PriceQuotation::class,
            'allow_extra_fields' => true
        ));
    }
}