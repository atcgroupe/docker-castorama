<?php

namespace App\Service\Order;

use App\Entity\AbstractOrderSign;
use App\Entity\MaterialSectorOrderSign;
use App\Entity\Order;
use App\Entity\Sign;
use Doctrine\ORM\EntityManagerInterface;

class OrderSignHelper
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
    ) {
    }

    /**
     * @param Order $order
     * @return array
     */
    public function findAll(Order $order): array
    {
        $allSigns = [];
        foreach ($this->getSigns() as $sign) {
            $signs = $this->manager->getRepository($sign->getClass())->findBy(['order' => $order]);
            if (!empty($signs)) {
                $allSigns = array_merge($allSigns, $signs);
            }
        }

        return $allSigns;
    }

    /**
     * @param Order $order
     * @return void
     */
    public function removeAll(Order $order): void
    {
        $signs = $this->getSigns();

        foreach ($signs as $sign) {
            $this->manager->getRepository($sign->getClass())->removeByOrder($order);
        }
    }

    /**
     * Saves new sign in the database.
     *
     * This method has been added because
     * if the sign entity is an instance of MaterialSectorOrderSign and alignment attribute is set to "all",
     * The sign is duplicated and two entities are saved in the database:
     * one with "left" alignment and one with "right" alignment
     *
     * @param AbstractOrderSign $sign
     * @return void
     */
    public function createOne(AbstractOrderSign $sign): void
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
     * @return Sign[]
     */
    private function getSigns(): array
    {
        return $this->manager->getRepository(Sign::class)->findAll();
    }
}
