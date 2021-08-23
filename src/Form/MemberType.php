<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Nom du membre',
                    'help' => 'Les membres permettent d\'identifier qui effectue des actions dans l\'application' .
                        ' (Cela peut être une personne, un service, ...)'
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'help' => 'L\'adresse e-mail permet l\'envoi des notifications lors des changements de statut' .
                        'd\'une commande (Ces notifications sont personnalisables a tout moment.)'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
