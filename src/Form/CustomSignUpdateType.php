<?php

namespace App\Form;

use App\Entity\Sign;
use App\Enum\CustomSignFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomSignUpdateType extends CustomSignCreateType
{
    public const UPDATE_TYPE = 'update_type';
    private const UPDATE_INFO = 'info';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        parent::buildForm($builder, $options);

        if ($options[self::UPDATE_TYPE] === self::UPDATE_INFO) {
            $builder
                ->remove('chooseFile')
                ->remove('previewFile')
                ->remove('productionFile');

            return;
        }

        $builder
            ->remove('name')
            ->remove('title')
            ->remove('weight')
            ->remove('price')
            ->remove('width')
            ->remove('height')
            ->remove('printFaces')
            ->remove('material')
            ->remove('finish')
            ->remove('customerReference')
            ->remove('category');

        match ($options[self::UPDATE_TYPE]) {
            CustomSignFileType::Choose
                => $builder->remove('previewFile')->remove('productionFile'),
            CustomSignFileType::Preview
                => $builder->remove('chooseFile')->remove('productionFile'),
            CustomSignFileType::Production
                => $builder->remove('chooseFile')->remove('previewFile'),
        };
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sign::class,
            'validation_groups' => ['update'],
            self::UPDATE_TYPE => self::UPDATE_INFO,
        ]);
    }
}
