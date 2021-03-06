<?php

namespace AppBundle\Form\PriceQuotation;
use AppBundle\Entity\PriceQuotation\PriceQuotationDetail;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class PriceQuotationDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('priceQuotation', EntityType::class, array(
                'class' => 'AppBundle\Entity\PriceQuotation\PriceQuotation',
                'choice_label' => function ($p) {
                    return $p->getCode() . ' - ' . $p->getCustomer()->getBusinessName();
                },
                'placeholder' => 'Nessuno',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input bg-aliceblue'
                ),
                'required' => false
            ))
            ->add('serviceType', EntityType::class, array(
                'class' => 'AppBundle:ServiceType',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')->select('s');
                },
                'choice_label' => 'service_name',
                'placeholder' => 'Frequenza',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input service_type_select'
                )
            ))
            ->add('serviceCode', EntityType::class, array(
                'class' => 'AppBundle:Service',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')->select('s');
                },
                'choice_label' => 'service',
                'placeholder' => 'Tipo Servizio',
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input service_select'
                )
            ))
            ->add('vat', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('name', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('description', TextareaType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('stages', CollectionType::class, array(
                'entry_type' => StageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'constraints' => array(new Valid()),
            ))
            ->add('price', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('wrongDates', CheckboxType::class, array(
                'attr' => array(
//                    'class' => 'form-control m-input'
                ),
                'required' => false
            ))
            ->add('attachment', AttachmentType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PriceQuotationDetail::class
        ));
    }
}