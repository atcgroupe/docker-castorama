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
    public const CREATE = 'ORDER_CREATE';
    public const DELETE = 'DELETE';
    public const SEND = 'SEND';
    public const UPDATE_DELIVERY_DATE = 'UPDATE_DELIVERY_DATE';
    public const UPDATE_INFO = 'UPDATE_INFO';
    public const UPDATE_SIGN = 'UPDATE_SIGN';

    public function __construct(
        private readonly Security $security,
    ) {
    }

    protected function supports(string $attribute, $subject): bool
    {
        if ($attribute === self::CREATE) {
            return true;
        }

        return in_array(
            $attribute,
            [
                self::DELETE,
                self::SEND,
                self::UPDATE_DELIVERY_DATE,
                self::UPDATE_INFO,
                self::UPDATE_SIGN,
            ]
        ) && $subject instanceof Order;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        return match ($attribute) {
            self::CREATE => $this->canCreate(),
            self::DELETE => $this->canDelete($subject),
            self::SEND => $this->canSend($subject),
            self::UPDATE_DELIVERY_DATE => $this->canUpdateDeliveryDate($subject),
            self::UPDATE_INFO => $this->canUpdateInfo($subject),
            self::UPDATE_SIGN => $this->canUpdateSign($subject),
            default => false
        };
    }

    private function canCreate(): bool
    {
        return
            $this->security->isGranted('ROLE_CUSTOMER_ADMIN') ||
            $this->security->isGranted('ROLE_CUSTOMER_SHOP')
        ;
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
            (
                $this->security->isGranted(User::ROLE_CUSTOMER_SHOP) ||
                $this->security->isGranted('ROLE_CUSTOMER_ADMIN')
            )
            && $order->getStatus()->getId() === OrderStatus::CREATED
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
            (
                $this->security->isGranted(User::ROLE_CUSTOMER_SHOP) ||
                $this->security->isGranted('ROLE_CUSTOMER_ADMIN')
            )
            && $order->getStatus()->getId() === OrderStatus::CREATED
        ;
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
            $order->getStatus()->getId() !== OrderStatus::DELIVERED
        ;
    }

    /**
     * @param Order $order
     * @return bool
     */
    public function canUpdateInfo(Order $order): bool
    {
        return
            (
                $this->security->isGranted('ROLE_CUSTOMER_SHOP') ||
                $this->security->isGranted('ROLE_CUSTOMER_ADMIN')
            )
            && $order->getStatus()->getId() !== OrderStatus::DELIVERED
        ;
    }

    /**
     * @param Order $order
     * @return bool
     */
    private function canUpdateSign(Order $order): bool
    {
        return
            (
                $this->security->isGranted('ROLE_CUSTOMER_SHOP') ||
                $this->security->isGranted('ROLE_CUSTOMER_ADMIN')
            )
            && $order->getStatus()->getId() === OrderStatus::CREATED
        ;
    }
}
