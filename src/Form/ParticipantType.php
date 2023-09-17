<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [

                'row_attr' => [
                    'class' => 'input-field col s12'
                ],
                'label' => 'Nom sur la carte',
                'attr' => [
                    'id' => 'name',
                    'class' => 'validate'
                ]

            ])
            ->add('email', EmailType::class, [
                'row_attr' => [
                    'class' => 'input-field col s12 l6'
                ],
                'label' => 'Votre Email',
                'attr' => [
                    'id' => 'email',
                    'class' => 'validate'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
