<?php

namespace App\Controller\Order\Sign;

use App\Repository\FixedSignRepository;
use App\Repository\SignRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order', name: 'order_sign')]
class OrderSignController extends AbstractController
{
    public function __construct(
        private readonly SignRepository $signRepository,
        private readonly FixedSignRepository $fixedSignRepository,
    ) {
    }

    #[Route('/{orderId}/sign/choose-category', name: '_choose_category')]
    public function chooseCategory(int $orderId): Response
    {
        return $this->render('order/sign/choose_category.html.twig', ['orderId' => $orderId]);
    }

    #[Route('/{orderId}/sign/{category}/choose', name: '_choose')]
    public function choose(int $orderId, int $category): Response
    {
        $variableSigns = $this->signRepository->findBy(['isActive' => true, 'category' => $category]);
        $fixedSigns = $this->fixedSignRepository->findBy(['isActive' => true, 'category' => $category]);

        return $this->render(
            'order/sign/choose.html.twig',
            [
                'orderId' => $orderId,
                'variableSigns' => $variableSigns,
                'fixedSigns' => $fixedSigns,
            ]
        );
    }
}
