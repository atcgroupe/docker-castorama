<?php

namespace App\Entity;

interface OrderSignInterface
{
    public function getQuantity(): ?int;

    public function getOrder(): ?Order;

    /**
     * Returns the type of the sign (aisle, sector, ...)
     *
     * @return string
     */
    public static function getType(): string;
}
