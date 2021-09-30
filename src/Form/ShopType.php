<?php

namespace App\Form;

use App\Entity\Shop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Intitulé du magasin',
                    'help' => 'Nom réel utilisé pour l\'adresse d\'éxpédition'
                ]
            )
            ->add(
                'address',
                TextareaType::class,
                [
                    'label' => 'Adresse',
                    'attr' => [
                        'rows' => 3,
                    ]
                ]
            )
            ->add('postCode', TextType::class, ['label' => 'Code postal'])
            ->add('region', TextType::class, ['label' => 'Région'])
            ->add('city', TextType::class, ['label' => 'Ville'])
            ->add(
                'deliveryInfo',
                TextareaType::class,
                [
                    'label' => 'Infos de livraison',
                    'required' => false,
                    'attr' => [
                        'rows' => 5
                    ]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Shop::class,
        ]);
    }
}
