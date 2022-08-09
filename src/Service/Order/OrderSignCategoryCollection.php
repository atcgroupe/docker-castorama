<?php

namespace App\Service\Order;

use App\Entity\SignCategory;

class OrderSignCategoryCollection
{
    /**
     * @param SignCategory $category
     * @param OrderSignCollection[] $collections
     */
    public function __construct(
        public readonly SignCategory $category,
        public readonly array $collections
    ) {
    }
}
