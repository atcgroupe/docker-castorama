<?php

namespace App\Service\Order;

use App\Entity\AbstractOrderSign;
use App\Entity\AbstractVariableOrderSign;
use App\Entity\MaterialSectorOrderSign;
use App\Entity\Order;
use App\Entity\Sign;
use Doctrine\ORM\EntityManagerInterface;

class OrderSignHelper
{
    public function __construct(
        private readonly VariableOrderSignHelper $variableOrderSignHelper,
        private readonly FixedOrderSignHelper $fixedOrderSignHelper,
    ) {
    }

    /**
     * @param Order $order
     *
     * @return array
     */
    public function findAll(Order $order): array
    {
        $fixedSigns = $this->fixedOrderSignHelper->findAll($order);
        $variableSigns = $this->variableOrderSignHelper->findAll($order);

        return array_merge($fixedSigns, $variableSigns);
    }

    public function removeAll(Order $order): void
    {
        $this->fixedOrderSignHelper->removeAll($order);
        $this->variableOrderSignHelper->removeAll($order);
    }

    /**
     * @param Order $order
     *
     * @return array|null
     */
    public function getResume(Order $order): ?OrderSignsResume
    {
        $variableSignsResume = $this->variableOrderSignHelper->getResume($order);
        $fixedSignsResume = $this->fixedOrderSignHelper->getResume($order);

        if (empty($variableSignsResume) && empty($fixedSignsResume)) {
            return null;
        }

        return new OrderSignsResume(array_merge($variableSignsResume, $fixedSignsResume));
    }
}
