<?php

namespace App\Form;

use App\Entity\AbstractSign;
use App\Entity\FixedSign;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FixedSignCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Nom',
                    'help' => 'Utilisé pour nommer les fichiers de production et de previsu.',
                    'attr' => [
                        'placeholder' => 'my_sign_name',
                    ]
                ]
            )->add(
                'title',
                TextType::class,
                [
                    'label' => 'Titre',
                    'help' => 'Utilisé pour l\'affichage lors de la creation des panneaux et pour la génération des fichiers pour le flux Switch',
                    'attr' => [
                        'placeholder' => 'Panneau secteur',
                    ]
                ]
            )->add(
                'weight',
                NumberType::class,
                [
                    'label' => 'Poids',
                    'scale' => 2,
                    'help' => 'En kg',
                    'attr' => [
                        'placeholder' => '10.25',
                    ]
                ]
            )->add(
                'price',
                NumberType::class,
                [
                    'label' => 'Prix',
                    'scale' => 2,
                    'attr' => [
                        'placeholder' => '40.22',
                    ]
                ]
            )
            ->add('width', NumberType::class, ['label' => 'Largeur', 'help' => 'En millimètres'])
            ->add('height', NumberType::class, ['label' => 'Hauteur', 'help' => 'En millimètres'])
            ->add(
                'printFaces',
                ChoiceType::class,
                [
                    'label' => 'Faces imprimées',
                    'choices' => [
                        'RECTO' => 'RECTO',
                        'RECTO/VERSO' => 'RECTO/VERSO'
                    ],
                ]
            )->add(
                'material',
                TextType::class,
                [
                    'label' => 'Matière',
                    'help' => 'Préciser l\'épaisseur',
                    'attr' => [
                        'placeholder' => 'Dibond 3MM',
                    ]
                ]
            )->add(
                'finish',
                TextType::class,
                [
                    'label' => 'Finition',
                    'required' => false,
                    'attr' => [
                        'placeholder' => '2 Perfos hautes',
                    ]
                ]
            )->add('customerReference', TextType::class, ['label' => 'Référence DataMerch'])
            ->add(
                'category',
                ChoiceType::class,
                [
                    'label' => 'Catégorie',
                    'choices' => [
                        'Signalétique interieure' => AbstractSign::CATEGORY_INDOOR,
                        'Cour des matériaux' => AbstractSign::CATEGORY_OUTDOOR,
                    ]
                ]
            )->add(
                'chooseFile',
                FileType::class,
                [
                    'label' => 'Illustration (Choix du panneau)',
                    'help' => 'Fichier jpg 300x300px. Utilisé pour présenter le panneau lors de la sélection du modèle, lors de l\'ajout d\'un nouveau panneau',
                    'row_attr' => [
                        'class' => 'mb-3'
                    ],
                    'attr' => [
                        'accept' => 'image/jpeg',
                    ],
                ]
            )->add(
                'previewFile',
                FileType::class,
                [
                    'label' => 'Vue détaillée du panneau',
                    'help' => 'Fichier jpg. affiché à droite du formulaire d\'ajout/modification d\'un panneau',
                    'row_attr' => [
                        'class' => 'mb-3'
                    ],
                    'attr' => [
                        'accept' => 'image/jpeg',
                    ],
                ]
            )->add(
                'productionFile',
                FileType::class,
                [
                    'label' => 'Fichier de production',
                    'help' => 'Format pdf uniquement',
                    'row_attr' => [
                        'class' => 'mb-3'
                    ],
                    'attr' => [
                        'accept' => 'application/pdf,application/x-pdf',
                    ],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FixedSign::class,
            'validation_groups' => ['create']
        ]);
    }
}
