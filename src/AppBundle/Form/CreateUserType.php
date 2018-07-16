<?php

namespace AppBundle\Form;
use AppBundle\Entity\User;
use AppBundle\Form\DataTransformer\StringToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CreateUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new StringToArrayTransformer();
        $builder
            ->add('username', TextType::class, array(
                'attr' => array(
                    'class' => 'm-input form-control'
                )
            ))
            ->add('password', PasswordType::class, array(
                'attr' => array(
                    'class' => 'm-input form-control'
                )
            ))
            ->add($builder->create('roles', ChoiceType::class, array(
                'multiple' => true,
                'choices'  => array(
                    'Admin'  => 'ROLE_ADMIN',
                    'Driver' => 'ROLE_DRIVER'
                ),
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->addModelTransformer($transformer))
            ->add('status', CheckboxType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input',
                    'data-switch' => 'true',
                    'data-on-color' => 'success',
                    'data-off-color' => 'warning'
                ),
                'required' => true
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }
}