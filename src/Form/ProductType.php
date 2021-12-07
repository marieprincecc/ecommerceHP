<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('file',FileType::class,[
            'label' => 'Ajouter une image',
            'mapped' => false,
            'constraints' => [
            new File([
            'maxSize' => '1m'
            ])
            ],
            ])
            ->add('name',TextType::class,[
            'label' => 'Nom du produit'
            ])
            ->add('price',MoneyType::class,[
            'divisor' => 100,
            'currency' => 'EUR',
            ])
            ->add('category',EntityType::class,[
                'label' => 'Categorie',
                'placeholder' => '-- Choisir une categorie --',
                'class' => Category::class
            ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
