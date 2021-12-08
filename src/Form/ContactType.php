<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject',TextType::class,[
                'required' => false,
                'label' => 'Sujet du message',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez renseigner le sujet de votre message.'
                    ]),
                ]
            ])
            ->add('content',TextareaType::class,[
                'required' => false,
                'label' => 'Contenu du message',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez rédiger un contenu.'
                    ]),
                ]
            ])
            ->add('fullname',TextType::class,[
                'required' => false,
                'label' => 'Prénom et nom de famille',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez inscrire votre nom complet.'
                    ]),
                ]
            ])
            ->add('email',TextType::class,[
                'required' => false,
                'label' => 'Votre email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez inscrire votre email.'
                    ]),
                ]
            ])
            ->add('telephone',TextType::class,[
                'required' => false,
                'label' => 'Votre téléphone',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez inscrire votre téléphone.'
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
