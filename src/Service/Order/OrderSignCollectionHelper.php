<?php

namespace App\Service\Order;

use App\Entity\CustomOrderSign;
use App\Entity\Order;
use App\Entity\Sign;
use App\Entity\SignCategory;
use App\Repository\SignCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderSignCollectionHelper
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly SignCategoryRepository $categoryRepository,
    ) {
    }

    /**
     * @param Order $order
     * @return OrderSignCategoryCollection[]
     */
    public function getCollections(Order $order): array
    {
        $categories = $this->categoryRepository->findAll();
        $data = [];
        foreach ($categories as $category) {
            $collections = $this->getCategoryCollections($order, $category);
            if (!empty($collections)) {
                $data[] = new OrderSignCategoryCollection($category, $collections);
            }
        }

        return $data;
    }

    /**
     * @param Order $order
     * @param SignCategory $category
     * @return OrderSignCollection[]
     */
    private function getCategoryCollections(Order $order, SignCategory $category): array
    {
        $collections = [];
        $signs = $this->manager->getRepository(Sign::class)->findBy(['category' => $category]);
        foreach ($signs as $sign) {
            $items = ($sign->isCustomType()) ?
                $this->manager->getRepository(CustomOrderSign::class)->findByOrderWithRelations($order, $sign) :
                $this->manager->getRepository($sign->getClass())->findByOrderWithRelations($order);
            if (!empty($items)) {
                $collections[] = new OrderSignCollection($sign, $items);
            }
        }

        return $collections;
    }
}
