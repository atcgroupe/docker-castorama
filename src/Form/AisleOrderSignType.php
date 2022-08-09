<?php

namespace App\Form;

use App\Entity\AisleOrderSign;
use App\Entity\AisleSignItem;
use App\Entity\AisleSignItemCategory;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AisleOrderSignType extends AbstractType
{
    private const ITEM_CATEGORY_SELECT = 'item_category_select';
    private const ITEM_SELECT = 'item_select';
    private const ITEM_CHECKBOX = 'item_checkbox';

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('aisleNumber', NumberType::class, ['label' => 'Numéro d\'allée', 'attr' => ['autofocus' => true]])
            ->add('quantity', NumberType::class, ['label' => 'Quantité'])
            ->add(
                'category',
                EntityType::class,
                [
                    'class' => AisleSignItemCategory::class,
                    'choice_label' => 'label',
                    'placeholder' => 'Choisissez un sous-secteur',
                    'label' => 'Sous-secteur',
                    'attr' => [
                        'class' => self::ITEM_CATEGORY_SELECT . ' mb-2',
                        'data-route' => $this->urlGenerator->generate('order_sign_aisle_select_item'),
                    ],
                ]
            )->add(
                'hideItem2Image',
                CheckboxType::class,
                [
                    'label' => 'Masquer le pictogramme',
                    'required' => false,
                    'attr' => [
                        'class' => self::ITEM_CHECKBOX,
                    ],
                ]
            )->add(
                'hideItem3Image',
                CheckboxType::class,
                [
                    'label' => 'Masquer le pictogramme',
                    'required' => false,
                    'attr' => [
                        'class' => self::ITEM_CHECKBOX,
                    ],
                ]
            )->add(
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

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $sign = $event->getData();

            $this->formItemsModifier($form, $sign->getCategory());
        });

        $builder->get('category')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
               $this->formItemsModifier($event->getForm()->getParent(), $event->getForm()->getData());
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AisleOrderSign::class,
            SignSaveType::ACTION_TYPE => SignSaveType::CREATE,
        ]);
    }

    /**
     * @param FormInterface $form
     * @param               $category
     */
    protected function formItemsModifier(FormInterface $form, $category)
    {
        for ($itemNumber = 1; $itemNumber < 4; $itemNumber ++) {
            $options = [
                'class' => AisleSignItem::class,
                'choice_label' => 'label',
                'placeholder' => '',
                'label' => 'Produit n°' . $itemNumber,
                'query_builder' => function (EntityRepository $repository) use ($category) {
                    return $repository->createQueryBuilder('s')
                        ->andWhere('s.category = :category')
                        ->setParameter('category', $category)
                        ->orderBy('s.label', 'ASC');
                },
                'attr' => [
                    'class' => self::ITEM_SELECT . ' mb-1',
                    'data-route' => $this->urlGenerator->generate('order_sign_aisle_item_info'),
                    'data-item' => $itemNumber,
                ],
                'row_attr' => [
                    'class' => 'mb-1'
                ],
            ];

            if ($itemNumber !== 1 && null === $category) {
                $options['disabled'] = true;
            }

            if ($itemNumber !== 1) {
                $options['required'] = false;
            }

            $form->add('item' . $itemNumber, EntityType::class, $options);
        }
    }
}
