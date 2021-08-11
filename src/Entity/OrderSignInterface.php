<?php

namespace App\Entity;

interface OrderSignInterface
{
    public function getQuantity(): ?int;

    public function getOrder(): ?Order;
}
