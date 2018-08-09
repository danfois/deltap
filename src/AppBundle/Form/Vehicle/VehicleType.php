<?php

namespace AppBundle\Form\Vehicle;
use AppBundle\Entity\Vehicle\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('exPlate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('carRegistrationDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('carRegistrationNumber', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('registrationCardDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('brand', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('model', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('seats', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input int_touch_spin'
                )
            ))
            ->add('stands', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input int_touch_spin'
                )
            ))
            ->add('width', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('length', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('purchaseDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('saleDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                ),
                'required' => false
            ))
            ->add('useTypology', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'choices' => array(
                    'Autonoleggio' => 'Autonoleggio',
                    'Linea' => 'Linea',
                    'Noleggio' => 'Noleggio',
                    'Uso Privato' => 'Uso Privato',
                    'Altro' => 'Altro'
                ),
                'multiple' => false
            ))
            ->add('useDestination', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('bodyWork', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('frame', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('owner', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                    //todo: autocomplete coi dati dei dipendenti / clienti / fornitori
                )
            ))
            ->add('transmission', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'choices' => array(
                    'Nessuno' => 'Nessuno',
                    'Automatico' => 'Automatico',
                    'Meccanico' => 'Meccanico'
                ),
                'multiple' => false
            ))
            ->add('tires', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('alternateTires', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('regionalAuthorization', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('areation', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('passengersSeated', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('passengersStanding', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('emergencyExits', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input int_touch_spin'
                )
            ))
            ->add('omologationNumber', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('maximumLoadMass', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('category', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('axesNumber', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input int_touch_spin'
                )
            ))
            ->add('engineCapacity', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input int_touch_spin'
                )
            ))
            ->add('engineNumber', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('powerKw', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input int_touch_spin'
                )
            ))
            ->add('fuel', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'choices' => array(
                    'Gasolio' => 'Gasolio',
                    'Benzina' => 'Benzina',
                    'Ibrido'  => 'Ibrido'
                ),
                'multiple' => false
            ))
            ->add('fireExtinguisherNumber', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('fireExtinguisherExpiration', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('notes', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('financing', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Vehicle::class
        ));
    }
}