<?php

namespace App\Service\Order;

use App\Entity\AbstractOrderSign;
use App\Entity\Order;
use App\Entity\Sign;
use Doctrine\ORM\EntityManagerInterface;

class OrderSignResumeHelper
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
    ) {
    }

    /**
     * @param Order $order
     * @return array|null
     */
    public function getResume(Order $order): ?OrderSignsResume
    {
        $resumes = [];
        $signs = $this->manager->getRepository(Sign::class)->findAll();
        foreach ($signs as $sign) {
            $repository = $this->manager->getRepository($sign->getClass());
            $count = $this->countSigns($repository->findBy(['order' => $order, 'sign' => $sign]));

            if ($count > 0) {
                $resumes[] = new OrderSignResume(
                    $sign->getCategory()->getLabel(),
                    $sign->getTitle(),
                    $sign->isCustomType(),
                    $sign->getCustomerReference(),
                    $count,
                    $repository->count(['order' => $order]),
                    $sign->getPrice(),
                    $sign->getPrice() * $count
                );
            }
        }

        if (empty($resumes)) {
            return null;
        }

        return new OrderSignsResume($resumes);
    }

    /**
     * @param AbstractOrderSign[] $signs
     * @return int
     */
    private function countSigns(array $signs): int
    {
        $count = 0;
        foreach ($signs as $sign) {
            $count += $sign->getQuantity();
        }

        return $count;
    }
}
