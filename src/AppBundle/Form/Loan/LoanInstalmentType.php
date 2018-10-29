<?php

namespace AppBundle\Form\Loan;

use AppBundle\Entity\Loan\LoanInstalment;
use AppBundle\Form\DataTransformer\StringToDateTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoanInstalmentType extends AbstractType
{
    protected $transformer;

    public function __construct(StringToDateTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $addingInstalmentOnly = $options['addingInstalmentOnly'];

        $builder
            ->add('paymentDate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input date_picker'
                )
            ))
            ->add('amount', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                )
            ))
            ->add('capital', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                ),
                'empty_data' => 0,
                'required' => false
            ))
            ->add('interests', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
                ),
                'empty_data' => 0,
                'required' => false
            ))
            ->add('interestRate', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input touch_spin'
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
                'placeholder' => 'Scegli tipo di pagamento',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('bankAccount', EntityType::class, array(
                'class' => 'AppBundle\Entity\Payment\BankAccount',
                'choice_label' => function ($ba) {
                    return $ba->getBankName() . ' - ' . $ba->getAccountNumber();
                },
                'empty_data' => null,
                'placeholder' => 'Scegli il conto',
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ));

        if($addingInstalmentOnly === true) {
            $builder
                ->add('loan', EntityType::class, array(
                    'class' => 'AppBundle\Entity\Loan\Loan',
                    'choice_label' => function ($loan) {
                        return $loan->getProvider()->getBusinessName() . ' - ' . $loan->getLoanNumber();
                    },
                    'empty_data' => null,
                    'attr' => array(
                        'class' => 'form-control m-input'
                    )
            ));
        }

        $builder->get('paymentDate')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => LoanInstalment::class,
            'addingInstalmentOnly' => false
        ));
    }
}