<?php

namespace AppBundle\Form\PriceQuotation;

use AppBundle\Entity\PriceQuotation\Demand;
use AppBundle\Form\DataTransformer\StringToDateTimeTransformer;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandType extends AbstractType
{
    protected $transformer;

    public function __construct(StringToDateTimeTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('priceQuotation', EntityType::class, array(
                'class' => 'AppBundle\Entity\PriceQuotation\PriceQuotation',
                'choice_label' => 'code',
                'empty_data' => null,
                'placeholder' => 'Nessuno',
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('demandDateTime', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_time_picker'
                )
            ))
            ->add('comunication', ChoiceType::class, array(
                'choices' => array(
                    'Telefono' => 'Telefono',
                    'Email' => 'Email',
                    'Fax' => 'Fax',
                    'Verbale' => 'Verbale'
                ),
                'empty_data' => null,
                'placeholder' => 'Scegli Modalità',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('requestedBy', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('receiver', EntityType::class, array(
                'class' => 'AppBundle\Entity\User',
                'choice_label' => function($u) {
                    if($u->getEmployee() != null) {
                        return $u->getEmployee()->getName() . " " . $u->getEmployee()->getSurname();
                    } else {
                        return $u->getUsername();
                    }
                },
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')->select('c')->orderBy('c.username');
                },
                'empty_data' => null,
                'placeholder' => 'Scegli Utente',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('subject', TextareaType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('demandType', ChoiceType::class, array(
                'choices' => array(
                    'Nuovo Preventivo' => 1,
                    'Modifica Preventivo' => 2,
                    'Conferma Preventivo' => 3,
                    'Richiesta Generica' => 4
                ),
                'empty_data' => null,
                'placeholder' => 'Scegli Tipologia',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ));

        $builder->get('demandDateTime')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Demand::class
        ));
    }
}