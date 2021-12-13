<?php

namespace App\Form;

use App\Entity\Category;
use App\Search\SearchProduct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchProductType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filterByName', TextType::class, [
                'label' => 'Filtrer par nom de produit',
                'required' => false,
            ])
            ->add('filterByCategory', EntityType::class, [
                'label' => 'Filtrer par catégorie',
                'placeholder' => '-- Choisir --',
                'class' => Category::class,
                'required' => false,
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchProduct::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}