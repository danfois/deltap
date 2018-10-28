<?php

namespace AppBundle\Form\Loan;

use AppBundle\Entity\Loan\Loan;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class LoanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('provider', EntityType::class, array(
                'class' => 'AppBundle\Entity\Provider',
                'choice_label' => 'businessName',
                'empty_data' => null,
                'placeholder' => 'Scegli il fornitore',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('loanNumber', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('loanDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('financedAmount', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('interestRate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('interestType', ChoiceType::class, array(
                'choices' => array(
                    'Fisso' => 'FIXED',
                    'Variabile' => 'VARIABLE',
                    'Misto' => 'MIXED'
                ),
                'empty_data' => null,
                'placeholder' => 'Scegli il tipo di interessi',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('instalmentType', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('instalmentNumber', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input int_touch-spin'
                )
            ))
            ->add('firstInstalmentDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('lastInstalmentDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('paymentType', ChoiceType::class, array(
                'choices' => array(
                    'Contanti' => 'CASH',
                    'Bonifico' => 'TRANSFER',
                    'Assegno' => 'CHECK',
                    'RID' => 'RID'
                ),
                'empty_data' => null,
                'placeholder' => 'Metodo di Pagamento',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('anticipation', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin',
                ),
                'empty_data' => 0,
                'required' => false
            ))
            ->add('redemption', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                ),
                'empty_data' => 0,
                'required' => false
            ))
            ->add('mortgages', TextType::class, array(
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
            ->add('preAmortization', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                ),
                'empty_data' => 0,
                'required' => false
            ))
            ->add('operationCost', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                ),
                'empty_data' => 0,
                'required' => false
            ))
            ->add('expectedInterests', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                ),
                'empty_data' => 0,
                'required' => false
            ))
            ->add('loanCost', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                ),
                'empty_data' => 0,
                'required' => false
            ))
            ->add('instalmentAmount', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('loanInstalments', CollectionType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                ),
                'entry_type' => LoanInstalmentType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'constraints' => array(new Valid()),
                'by_reference' => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Loan::class
        ));
    }
}