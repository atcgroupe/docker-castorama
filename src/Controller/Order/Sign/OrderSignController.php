<?php

namespace App\Controller\Order\Sign;

use App\Repository\SignRepository;
use App\Service\Controller\AbstractAppController;
use Symfony\Component\Routing\Annotation\Route;

class OrderSignController extends AbstractAppController
{
    #[Route('/order/{orderId}/sign/choose', name: 'order_sign_choose')]
    public function choose(int $orderId, SignRepository $signRepository)
    {
        $signs = $signRepository->findAll();

        return $this->render('order/sign/choose.html.twig', ['signs' => $signs, 'orderId' => $orderId]);
    }
}
