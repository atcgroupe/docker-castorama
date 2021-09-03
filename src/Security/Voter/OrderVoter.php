<?php

namespace App\Security\Voter;

use App\Entity\Order;
use App\Entity\OrderStatus;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class OrderVoter extends Voter
{
    public const DELETE = 'DELETE';
    public const SEND = 'SEND';
    public const UPDATE_DELIVERY_DATE = 'UPDATE_DELIVERY_DATE';
    public const UPDATE_INFO = 'UPDATE_INFO';

    public function __construct(
        private Security $security,
    ) {
    }

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::DELETE, self::SEND, self::UPDATE_DELIVERY_DATE, self::UPDATE_INFO])
            && $subject instanceof Order;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        return match ($attribute) {
            self::DELETE => $this->canDelete($subject),
            self::SEND => $this->canSend($subject),
            self::UPDATE_DELIVERY_DATE => $this->canUpdateDeliveryDate($subject),
            self::UPDATE_INFO => $this->canUpdateInfo($subject),
            default => false
        };
    }

    /**
     * @param Order $order
     *
     * @return bool
     */
    private function canDelete(Order $order): bool
    {
        if ($this->security->isGranted(User::ROLE_COMPANY_ADMIN)) {
            return true;
        }

        if (
            $order->getStatus()->getLabel() === OrderStatus::CREATED &&
            $this->security->isGranted(User::ROLE_CUSTOMER_SHOP)
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param Order $order
     *
     * @return bool
     */
    private function canSend(Order $order): bool
    {
        return
            $this->security->isGranted(User::ROLE_CUSTOMER_SHOP) &&
            $order->getStatus()->getLabel() === OrderStatus::CREATED;
    }

    /**
     * @param Order $order
     *
     * @return bool
     */
    private function canUpdateDeliveryDate(Order $order): bool
    {
        return
            $this->security->isGranted('ROLE_COMPANY_ADMIN') &&
            $order->getStatus()->getLabel() !== OrderStatus::DELIVERED;
    }

    public function canUpdateInfo(Order $order): bool
    {
        return
            $this->security->isGranted('ROLE_CUSTOMER_SHOP') &&
            $order->getStatus()->getLabel() !== OrderStatus::DELIVERED;
    }
}
