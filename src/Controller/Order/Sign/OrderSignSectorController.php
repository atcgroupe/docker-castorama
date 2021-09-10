<?php

namespace App\Controller\Order\Sign;

use App\Entity\AisleOrderSign;
use App\Repository\SignItemCategoryRepository;
use App\Service\Controller\AbstractAppController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order/{orderId}/sign/sector', name: 'order_sign_sector')]
class OrderSignSectorController extends AbstractAppController
{
    #[Route('/create', name: '_create')]
    public function create(int $orderId, SignItemCategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findBySignClass(AisleOrderSign::class);

        return $this->render(
            'order/sign/aisle_edit.html.twig',
            [
                'categories' => $categories,
                'orderId' => $orderId,
            ]
        );
    }
}
