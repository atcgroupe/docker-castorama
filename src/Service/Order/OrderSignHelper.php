<?php

namespace App\Service\Order;

use App\Entity\AbstractOrderSign;
use App\Entity\Order;
use App\Entity\Sign;
use Doctrine\ORM\EntityManagerInterface;

class OrderSignHelper
{
    public function __construct(
        private EntityManagerInterface $manager
    ) {
    }

    /**
     * @param Order $order
     *
     * @return array
     */
    public function findOrderSigns(Order $order): array
    {
        $signs = [];
        foreach ($this->getSignsTypes() as $type) {
            $elements = $this->manager->getRepository($type->getClass())->findByOrderWithRelations($order);
            if (!empty($elements)) {
                $signs[$type->getTitle()] = $elements;
            }
        }

        return $signs;
    }

    /**
     * @param Order $order
     *
     * @return array|null
     */
    public function getOrderSignsResume(Order $order): array | null
    {
        $signResume = [];
        $totalPrice = 0;
        $totalCount = 0;

        foreach ($this->getSignsTypes() as $type) {
            $repository = $this->manager->getRepository($type->getClass());
            $count = $this->countSigns($repository->findBy(['order' => $order]));
            $price = $type->getPrice();
            $countPrice = $count * $price;
            $totalCount += $count;
            $totalPrice += $countPrice;
            if ($count > 0) {
                $signResume[$type->getTitle()] = [
                    'count' => $count,
                    'unitPrice' => $type->getPrice(),
                    'countPrice' => $type->getPrice() * $count
                ];
            }
        }

        $resume = [
            'global' => [
                'count' => $totalCount,
                'price' => $totalPrice,
            ],
            'sign' => $signResume
        ];

        return ($totalCount > 0 ) ? $resume : null;
    }

    /**
     * @return Sign[]
     */
    private function getSignsTypes(): array
    {
        return $this->manager->getRepository(Sign::class)->findAll();
    }

    /**
     * @param AbstractOrderSign[] $signs
     */
    private function countSigns(array $signs)
    {
        $count = 0;
        foreach ($signs as $sign) {
            $count += $sign->getQuantity();
        }

        return $count;
    }
}
