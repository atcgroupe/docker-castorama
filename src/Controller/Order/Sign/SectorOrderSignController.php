<?php

namespace App\Controller\Order\Sign;

use App\Entity\SectorSignItem;
use App\Repository\SectorSignItemRepository;
use App\Service\Controller\AbstractAppController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order', name: 'order_sign_sector')]
class SectorOrderSignController extends AbstractAppController
{
    #[Route('/sign/sector/options', name: '_options')]
    public function getItem2Options(Request $request, SectorSignItemRepository $itemRepository): JsonResponse
    {
        $item = $itemRepository->find($request->request->get('item'));

        if (null === $item) {
            return new JsonResponse([]);
        }

        $items = $itemRepository->findBy(['color' => $item->getColor()]);

        $options = [];

        $options[] = [
            'value' => '',
            'label' => 'Choisissez un secteur',
        ];

        foreach ($items as $item) {
            $options[] = [
                'value' => $item->getId(),
                'label' => $item->getLabel(),
            ];
        }

        return new JsonResponse($options);
    }

    #[Route('/sign/sector/color', name: '_color')]
    public function getColor(Request $request, SectorSignItemRepository $itemRepository): JsonResponse
    {
        $item = $itemRepository->find($request->request->get('item'));

        return new JsonResponse(['color' => null === $item ? SectorSignItem::GREY : $item->getColor()]);
    }
}
