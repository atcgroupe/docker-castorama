<?php

namespace App\Form;

use App\Entity\MaterialSectorOrderSign;
use App\Entity\MaterialSectorSignItem;
use App\Entity\MaterialSectorSignItemCategory;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MaterialSectorOrderSignType extends AbstractType
{
    private const ITEM_CATEGORY_SELECT = 'item_category_select';
    private const ITEM_SELECT = 'item_select';

    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('aisleNumber', TextType::class, ['label' => 'Numéro d\'allée', 'attr' => ['autofocus' => true]])
            ->add(
                'alignment',
                ChoiceType::class,
                $this->getAlignmentOptions($options[SignSaveType::ACTION_TYPE]),
            )->add('quantity', NumberType::class, ['label' => 'Quantité'])
            ->add(
                'category',
                EntityType::class,
                [
                    'class' => MaterialSectorSignItemCategory::class,
                    'choice_label' => 'label',
                    'placeholder' => '',
                    'label' => 'Sous-secteur',
                    'attr' => [
                        'class' => self::ITEM_CATEGORY_SELECT . ' mb-2',
                        'data-route' => $this->urlGenerator->generate('order_sign_material_sector_select_item'),
                    ],
                ]
            )
            ->add('item1')
            ->add('item2')
            ->add('item3')
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MaterialSectorOrderSign::class,
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
                'class' => MaterialSectorSignItem::class,
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
                    'data-route' => $this->urlGenerator->generate('order_sign_material_sector_item_info'),
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

    /**
     * @param string $actionType SignSaveType::ACTION_TYPE
     * @return array
     */
    private function getAlignmentOptions(string $actionType): array
    {
        $choices = [
            'GAUCHE' => MaterialSectorOrderSign::ALIGN_LEFT,
            'DROITE' => MaterialSectorOrderSign::ALIGN_RIGHT,
        ];

        if ($actionType === SignSaveType::CREATE) {
            $choices['GAUCHE + DROITE'] = MaterialSectorOrderSign::ALIGN_ALL;
            $help = '
                Si vous selectionnez l\'option "GAUCHE + DROITE", lors de l\'enregistrement, deux panneaux seront créés:
                Un panneau gauche + un panneau droite.
                Ces panneaux resteront modifiables et supprimables séparément depuis la liste des panneaux
                dans le détail de la commande.
            ';
        }

        $options = [
            'label' => 'Alignement du texte',
            'choices' => $choices,
        ];

        if (isset($help)) {
            $options['help'] = $help;
        }

        return $options;
    }
}
