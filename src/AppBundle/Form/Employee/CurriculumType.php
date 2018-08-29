<?php

namespace AppBundle\Form\Employee;
use AppBundle\Entity\Employee\Curriculum;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CurriculumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('employee', EntityType::class, array(
                'class' => 'AppBundle\Entity\Employee\Employee',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->select('e');
                },
                'choice_label' => function($choice) {
                    return $choice->getName() . ' ' . $choice->getSurname();
                },
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('qualification', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('languages', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('workExperience', TextareaType::class, array(
                'attr' => array(
                    'class' => 'form-control m-input'
                )
            ))
            ->add('files', FileType::class, array(
                'multiple' => true,
                'attr' => array(
                    'class' => 'form-control m-input',
                    'multiple' => 'multiple'
                ),
                'mapped' => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Curriculum::class
        ));
    }
}