<?php

namespace App\Service\Order;

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
        $resume = [];
        $total = 0;
        foreach ($this->getSignsTypes() as $type) {
            $repository = $this->manager->getRepository($type->getClass());
            $count = $repository->count(['order' => $order]);

            $resume[$type->getTitle()] = $count;
            $total += $count;
        }

        return ($total > 0 ) ? $resume : null;
    }

    /**
     * @return Sign[]
     */
    private function getSignsTypes(): array
    {
        return $this->manager->getRepository(Sign::class)->findAll();
    }
}
