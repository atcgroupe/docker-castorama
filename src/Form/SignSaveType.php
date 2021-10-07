<?php

namespace App\Form;

use InvalidArgumentException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignSaveType extends AbstractType
{
    public const ACTION_TYPE = 'action_type';
    public const CREATE = 'CREATE';
    public const UPDATE = 'UPDATE';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        switch ($options[self::ACTION_TYPE]) {
            case self::CREATE:
                $builder
                    ->add(
                        'saveAndNew',
                        SubmitType::class,
                        [
                            'label' => 'Valider le panneau et poursuivre la saisie',
                            'attr' => [
                                'class' => 'btn btn-lg btn-primary w-100'
                            ],
                            'row_attr' => [
                                'class' => 'mb-2'
                            ]
                        ]
                    )->add(
                        'saveAndChoose',
                        SubmitType::class,
                        [
                            'label' => 'Valider le panneau et poursuivre avec d\'autres formats de panneaux',
                            'attr' => [
                                'class' => 'btn btn-lg btn-primary w-100'
                            ],
                            'row_attr' => [
                                'class' => 'mb-2'
                            ]
                        ]
                    )
                ;
                break;
            case self::UPDATE:
                $builder
                    ->add(
                        'update',
                        SubmitType::class,
                        [
                            'label' => 'Enregistrer les modifications',
                            'attr' => [
                                'class' => 'btn btn-lg btn-primary w-100'
                            ],
                            'row_attr' => [
                                'class' => 'mb-2'
                            ]
                        ]
                    )
                ;
                break;
            default:
                throw new InvalidArgumentException(sprintf(
                    'Invalid "%s" option value. Accepted values: %s or %s.',
                    self::ACTION_TYPE,
                    self::CREATE,
                    self::UPDATE
                ));
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            self::ACTION_TYPE => self::CREATE
        ]);
    }
}
