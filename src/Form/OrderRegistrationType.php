<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'user',
            EntityType::class,
            [
                'class' => User::class,
                'choice_label' => 'username',
                'label' => 'Sélectionnez un magasin',
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('u')
                        ->andWhere('u.roles LIKE :roles')
                        ->setParameter('roles', '%"' . User::ROLE_CUSTOMER_SHOP . '"%')
                        ->orderBy('u.username', 'ASC');
                }
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
