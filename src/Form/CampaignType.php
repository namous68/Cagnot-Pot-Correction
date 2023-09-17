<?php

namespace App\Form;

use App\Entity\Campaign;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampaignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de votre campagne',
                'attr' => [
                    'id' => 'title',
                    'class' => 'validate'
                ],
                'row_attr' => [
                    'class' => 'input-field col s12 l8'
                ]
            ])
            ->add('content', TextareaType::class, [
                'row_attr' => [
                    'class' => 'input-field col s12'
                ],
                'label' => '',
                'attr' => [
                    'id' => 'description',
                    'class' => 'materialize-textarea',
                    'placeholder' => 'Décrivez à vos amis pourquoi vous faites une campagne'
                ]
            ])
            ->add('goal', IntegerType::class, [
                'row_attr' => [
                    'class' => 'input-field col s12 l6'
                ],
                'label' => 'Votre objectif en euros',
                'attr' => [
                    'id' => 'goal',
                    'class' => 'validate'
                ]

            ])
            ->add('creatorName', TextType::class, [
                'row_attr' => [
                    'class' => 'input-field col s12 l6'
                ],
                'label' => 'Votre Nom',
                'attr' => [
                    'id' => 'creatorName',
                    'class' => 'validate'
                ]

            ])
            ->add('creatorEmail', EmailType::class, [
                'row_attr' => [
                    'class' => 'input-field col s12 l6'
                ],
                'label' => 'Votre Email',
                'attr' => [
                    'id' => 'creatorEmail',
                    'class' => 'validate'
                ]

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Campaign::class,
        ]);
    }
}
