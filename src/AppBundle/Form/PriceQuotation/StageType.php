<?php

namespace AppBundle\Form\PriceQuotation;
use AppBundle\Entity\PriceQuotation\Stage;
use AppBundle\Form\DataTransformer\StringToDateTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    protected $transformer;

    public function __construct(StringToDateTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('busNumber', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input int_touch_spin'
                )
            ))
            ->add('km', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
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
                )
            ))
            ->add('repeatedTimes', CollectionType::class, array(
                'entry_type' => RepeatedTimesType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false
            ))
            ->add('repeatedDays', ChoiceType::class, array(
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
            ->add('estimatedTime', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                ),
                'required' => false
            ))
            ->add('leftouts', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ));

        //todo: implementare quel coso tipo i tag separati da virgola

        $builder->get('departureDate')->addModelTransformer($this->transformer);
        $builder->get('arrivalDate')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Stage::class
        ));
    }
}