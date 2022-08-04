<?php

namespace App\Service\Order;

use App\Entity\Event;
use App\Entity\User;
use App\Repository\MemberRepository;
use App\Repository\OrderRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class OrderNotificationDispatcher
{
    public function __construct(
        private OrderRepository $orderRepository,
        private OrderSignHelper $orderSignHelper,
        private MemberRepository $memberRepository,
        private Environment $twig,
        private MailerInterface $mailer,
    ) {
    }

    public function send(int $orderId)
    {
        $order = $this->orderRepository->findOneWithRelations($orderId);
        $resume = $this->orderSignHelper->getResume($order);
        $addresses = $this->getMembersAddresses($order->getStatus()->getEvent(), $order->getUser());
        $content = $this->twig->render('email/order_notification.html.twig', ['order' => $order, 'resume' => $resume]);

        $email = (new Email())
            ->from(Address::create('Web2Print ATC Groupe <web2print@atc-groupe.com>'))
            ->to(...$addresses)
            ->subject('Notification de commande')
            ->html($content)
        ;

        $this->mailer->send($email);
    }

    /**
     * Returns list of members emails who has subscribed to the event
     *
     * @param Event $event
     * @param User  $user
     *
     * @return array
     */
    private function getMembersAddresses(Event $event, User $user): array
    {
        $members = $this->memberRepository->findByEventAndUser($event, $user);

        $addresses = [];
        foreach ($members as $member) {
            $addresses[] = $member->getEmail();
        }

        return $addresses;
    }
}
