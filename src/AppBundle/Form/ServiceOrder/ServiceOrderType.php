<?php

namespace AppBundle\Form\ServiceOrder;
use AppBundle\Entity\ServiceOrder\ServiceOrder;
use AppBundle\Form\DataTransformer\StringToDateTransformer;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceOrderType extends AbstractType
{
    protected $transformer;

    public function __construct(StringToDateTransformer $transformer)
    {
        $this->transformer = $transformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if($options['pqd'] != null) {
            $pqd = $options['pqd'];
        } else {
            $pqd = null;
        }

        $builder
            ->add('customer', EntityType::class, array(
                'class' => 'AppBundle:Customer',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')->select('c')->orderBy('c.businessName');
                },
                'choice_label' => 'business_name',
                'placeholder' => 'Scegli Cliente',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input customer_select'
                )
            ))
            ->add('priceQuotation', EntityType::class, array(
                'class' => 'AppBundle\Entity\PriceQuotation\PriceQuotation',
                'choice_label' => 'code',
                'placeholder' => 'Nessuno',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('priceQuotationDetail', EntityType::class, array(
                'class' => 'AppBundle\Entity\PriceQuotation\PriceQuotationDetail',
                'choice_label' => 'name',
                'placeholder' => 'Nessuno',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('stage', EntityType::class, array(
                'class' => 'AppBundle\Entity\PriceQuotation\Stage',
                'required' => false,
                'query_builder' => function(EntityRepository $er) use ($pqd) {
                    if($pqd !== null) {
                        return $er->createQueryBuilder('s')
                            ->select('s')
                            ->where('s.priceQuotationDetail = :dt')
                            ->setParameter(':dt', $pqd->getPriceQuotationDetailId());
                    } else {
                        return $er->createQueryBuilder('s')
                            ->select('s');
                    }
                },
                'choice_label' => function($stage) {
                    return $stage->getDepartureLocation() . ' - ' . $stage->getArrivalLocation();
                },
                'placeholder' => 'Nessuno',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('driver', EntityType::class, array(
                'class' => 'AppBundle\Entity\User',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')->select('c')->orderBy('c.username');
                },
                'choice_label' => function($u) {
                    if($u->getEmployee() != null) {
                        return $u->getEmployee()->getName() . " " . $u->getEmployee()->getSurname();
                    } else {
                        return $u->getUsername();
                    }
                },
                'placeholder' => 'Nessuno',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input',
                ),
                'required' => false
            ))
            ->add('vehicle', EntityType::class, array(
                'class' => 'AppBundle\Entity\Vehicle\Vehicle',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')->select('c')->orderBy('c.plate');
                },
                'choice_label' => 'plate',
                'placeholder' => 'Nessuno',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('serviceFrequency', EntityType::class, array(
                'class' => 'AppBundle:ServiceType',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')->select('s');
                },
                'choice_label' => 'service_name',
                'placeholder' => 'Tipo Servizio',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input service_type_select'
                )
            ))
            ->add('service', EntityType::class, array(
                'class' => 'AppBundle:Service',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')->select('s');
                },
                'choice_label' => 'service',
                'placeholder' => 'Servizio',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input service_select'
                )
            ))
            ->add('departureLocation', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input place_autocomplete'
                )
            ))
            ->add('arrivalLocation', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input place_autocomplete'
                )
            ))
            ->add('departureDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('arrivalDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('startTime', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input time_picker'
                )
            ))
            ->add('endTime', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input time_picker'
                )
            ))
            ->add('passengers', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input int_touch_spin'
                )
            ))
            ->add('price', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                ),
                'required' => false,
                'empty_data' => 0
            ))
            ->add('description', TextareaType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input summernote'
                )
            ))
            ->add('dispositions', TextareaType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input summernote'
                )
            ))
            ->add('directionsLink', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('vat', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                ),
                'required' => false,
                'empty_data' => 0
            ));

        $builder->get('departureDate')->addModelTransformer($this->transformer);
        $builder->get('arrivalDate')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ServiceOrder::class,
            'pqd' => null
        ));
    }
}