<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\OrderStatus;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderUpdateStatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'status',
            EntityType::class,
            [
                'label' => 'Statut de la commande',
                'class' => OrderStatus::class,
                'choice_label' => 'label',
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('o')
                        ->innerJoin('o.event', 'event')
                        ->orderBy('event.displayOrder', 'ASC');
                },
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
