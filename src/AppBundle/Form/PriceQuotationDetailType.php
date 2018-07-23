<?php

namespace AppBundle\Form;
use AppBundle\Entity\PriceQuotationDetail;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceQuotationDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('departure', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('arrival', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('description', TextareaType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input',
                    'style' => 'height:130px;'
                )
            ))
            ->add('departure_date', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('arrival_date', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('array_repeated_times', CollectionType::class, array(
                'entry_type' => RepeatedTimesType::class,
                'allow_add' => true,
                'required' => false
            ))
            ->add('array_repeated_days', ChoiceType::class, array(
                'choices' => array(
                    'Lun' => 1,
                    'Mar' => 2,
                    'Mer' => 3,
                    'Gio' => 4,
                    'Ven' => 5,
                    'Sab' => 6,
                    'Dom' => 7
                ),
                'multiple' => true,
                'expanded' => true,
                'required' => false
            ))
            ->add('bus_number', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('passengers', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('estimated_km', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('estimated_time', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('price', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('vat', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('status', ChoiceType::class, array(
                'choices' => array(
                    'In Sospeso' => 1,
                    'Confermato' => 2
                ),
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('vat_type', ChoiceType::class, array(
                'choices' => array(
                    'Iva Inclusa' => 1,
                    'Iva Esclusa' => 2,
                    'Iva Esente'  => 3
                ),
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('service_type', EntityType::class, array(
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
            ->add('service_code', EntityType::class, array(
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
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PriceQuotationDetail::class
        ));
    }
}