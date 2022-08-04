<?php

namespace App\Service\Order;

class OrderSignResume
{
    public function __construct(
        public readonly string $category,
        public readonly string $title,
        public readonly string $customerReference,
        public readonly int $signsCount,
        public readonly int $modelsCount,
        public readonly float $unitPrice,
        public readonly float $totalPrice,
    ) {
    }
}
