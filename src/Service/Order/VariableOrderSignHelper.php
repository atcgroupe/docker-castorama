<?php

namespace App\Service\Order;

use App\Entity\AbstractOrderSign;
use App\Entity\AbstractVariableOrderSign;
use App\Entity\MaterialSectorOrderSign;
use App\Entity\Order;
use App\Entity\Sign;
use Doctrine\ORM\EntityManagerInterface;

class VariableOrderSignHelper
{
    public function __construct(
        private readonly EntityManagerInterface $manager
    ) {
    }

    /**
     * @param Order $order
     *
     * @return VariableOrderSignCollection[]
     */
    public function getCollections(Order $order): array
    {
        $collections = [];
        foreach ($this->getSigns() as $sign) {
            $items = $this->manager->getRepository($sign->getClass())->findByOrderWithRelations($order);
            if (!empty($items)) {
                $collections[] = new VariableOrderSignCollection($sign, $items);
            }
        }

        return $collections;
    }

    /**
     * @param Order $order
     * @return AbstractVariableOrderSign[]
     */
    public function findAll(Order $order): array
    {
        $allSigns = [];
        foreach ($this->getSigns() as $sign) {
            $signs = $this->manager->getRepository($sign->getClass())->findByOrderWithRelations($order);
            if (!empty($signs)) {
                $allSigns = array_merge($allSigns, $signs);
            }
        }

        return $allSigns;
    }

    /**
     * @param Order $order
     *
     * @return OrderSignResume[]
     */
    public function getResume(Order $order): array
    {
        $resumes = [];
        foreach ($this->getSigns() as $sign) {
            $repository = $this->manager->getRepository($sign->getClass());
            $count = $this->countSigns($repository->findBy(['order' => $order]));

            if ($count > 0) {
                $resumes[] = new OrderSignResume(
                    $sign->getCategoryLabel(),
                    $sign->getTitle(),
                    $sign->getCustomerReference(),
                    $count,
                    $repository->count(['order' => $order]),
                    $sign->getPrice(),
                    $sign->getPrice() * $count
                );
            }
        }

        return $resumes;
    }

    /**
     * Saves new sign in the database.
     *
     * This method has been added because
     * if the sign entity is an instance of MaterialSectorOrderSign and alignment attribute is set to "all",
     * The sign is duplicated and two entities are saved in the database:
     * one with "left" alignment and one with "right" alignment
     *
     * @param AbstractVariableOrderSign $sign
     * @return void
     */
    public function createOne(AbstractVariableOrderSign $sign): void
    {
        if (
            $sign::class === MaterialSectorOrderSign::class &&
            $sign->getAlignment() === MaterialSectorOrderSign::ALIGN_ALL
        ) {
            $leftSign = $sign->setAlignment(MaterialSectorOrderSign::ALIGN_LEFT);
            $rightSign = clone $leftSign;
            $rightSign->setAlignment(MaterialSectorOrderSign::ALIGN_RIGHT);

            $this->manager->persist($leftSign);
            $this->manager->persist($rightSign);

            $this->manager->flush();

            return;
        }

        $this->manager->persist($sign);
        $this->manager->flush();
    }

    /**
     * @param Order $order
     * @return void
     */
    public function removeAll(Order $order): void
    {
        $signTypes = $this->getSigns();

        foreach ($signTypes as $type) {
            $this->manager->getRepository($type->getClass())->removeByOrder($order);
        }
    }

    /**
     * @return Sign[]
     */
    private function getSigns(): array
    {
        return $this->manager->getRepository(Sign::class)->findAll();
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
