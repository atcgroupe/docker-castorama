<?php

namespace App\Form;

use App\Entity\AisleOrderSign;
use App\Entity\AisleSignItem;
use App\Entity\AisleSignItemCategory;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('aisleNumber', TextType::class, ['label' => 'Numéro d\'allée'])
            ->add('quantity', NumberType::class, ['label' => 'Quantité', 'attr' => ['autofocus' => true]])
            ->add(
                'save',
                SubmitType::class,
                [
                    'label' => 'Enregistrer',
                    'attr' => [
                        'class' => 'btn btn-lg btn-outline-primary w-100 my-2'
                    ]
                ]
            )->add(
                'saveAndNew',
                SubmitType::class,
                [
                    'label' => 'Enregistrer & nouveau',
                    'attr' => [
                        'class' => 'btn btn-lg btn-outline-primary w-100 mb-4'
                    ]
                ]
            )
        ;

        $this->formCategoryModifier($builder, 1);
        $this->formCategoryModifier($builder, 2);
        $this->formCategoryModifier($builder, 3);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $sign = $event->getData();

            $this->formItemModifier($form, 1, $sign->getCategory1());
            $this->formItemModifier($form, 2, $sign->getCategory2());
            $this->formItemModifier($form, 3, $sign->getCategory3());
        });

        $builder->get('category1')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
               $this->formItemModifier($event->getForm()->getParent(), 1, $event->getForm()->getData());
            }
        );

        $builder->get('category2')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $this->formItemModifier($event->getForm()->getParent(), 2, $event->getForm()->getData());
            }
        );

        $builder->get('category3')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $this->formItemModifier($event->getForm()->getParent(), 3, $event->getForm()->getData());
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AisleOrderSign::class,
        ]);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param int                  $categoryNumber
     */
    private function formCategoryModifier(FormBuilderInterface $builder, int $categoryNumber)
    {
        $builder->add(
            'category' . $categoryNumber,
            EntityType::class,
            [
                'class' => AisleSignItemCategory::class,
                'choice_label' => 'label',
                'placeholder' => 'Choisissez une catégorie',
                'attr' => [
                    'class' => self::ITEM_CATEGORY_SELECT . ' mb-2',
                    'data-route' => $this->urlGenerator->generate('order_sign_aisle_select_item'),
                    'data-cible' => 'aisle_order_sign_item' . $categoryNumber,
                ],
            ]
        );
    }

    /**
     * @param FormInterface $form
     * @param int           $itemNumber
     * @param               $category
     */
    private function formItemModifier(FormInterface $form, int $itemNumber, $category)
    {
        $options = [
            'class' => AisleSignItem::class,
            'choice_label' => 'label',
            'placeholder' => '',
            'query_builder' => function (EntityRepository $repository) use ($category) {
                return $repository->createQueryBuilder('s')
                    ->andWhere('s.category = :category')
                    ->setParameter('category', $category);
            },
            'attr' => [
                'class' => self::ITEM_SELECT,
                'data-route' => $this->urlGenerator->generate('order_sign_aisle_item_info'),
                'data-item' => $itemNumber,
            ],
        ];

        if ($itemNumber !== 1 && null === $category) {
            $options['disabled'] = true;
        }

        $form->add('item' . $itemNumber, EntityType::class, $options);
    }
}
