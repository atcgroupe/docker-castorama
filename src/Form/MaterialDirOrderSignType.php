<?php

namespace App\Form;

use App\Entity\MaterialDirOrderSign;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterialDirOrderSignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                ChoiceType::class,
                [
                    'label' => 'TYPE',
                    'choices' => [
                        'CAISSES' => MaterialDirOrderSign::TITLE_CAISSE,
                        'SORTIE' => MaterialDirOrderSign::TITLE_SORTIE,
                        'CAISSES - SORTIE' => MaterialDirOrderSign::TITLE_CAISSE_SORTIE,
                    ]
                ]
            )->add(
                'direction',
                ChoiceType::class,
                [
                    'label' => 'DIRECTION',
                    'choices' => [
                        'GAUCHE' => MaterialDirOrderSign::DIR_LEFT,
                        'DROITE' => MaterialDirOrderSign::DIR_RIGHT,
                        'EN FACE' => MaterialDirOrderSign::DIR_TOP,
                    ]
                ]
            )->add('quantity', NumberType::class, ['label' => 'Quantité'])
            ->add(
                'save',
                SignSaveType::class,
                [
                    SignSaveType::ACTION_TYPE => $options[SignSaveType::ACTION_TYPE],
                    'mapped' => false,
                    'label' => false,
                    'row_attr' => [
                        'class' => 'mb-0'
                    ],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MaterialDirOrderSign::class,
            SignSaveType::ACTION_TYPE => SignSaveType::CREATE,
        ]);
    }
}
