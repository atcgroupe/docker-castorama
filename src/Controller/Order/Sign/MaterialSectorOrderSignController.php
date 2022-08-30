<?php

namespace App\Controller\Order\Sign;

use App\Repository\MaterialSectorSignItemRepository;
use App\Service\Controller\AbstractAppController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order', name: 'order_sign_material_sector')]
class MaterialSectorOrderSignController extends AbstractAppController
{
    #[Route('/sign/materialSector/edit/itemsList', name: '_select_item')]
    public function setSignItemsFromCategory(
        Request $request,
        MaterialSectorSignItemRepository $itemRepository
    ): JsonResponse {
        $items = $itemRepository->findBy(
            ['category' => $request->request->get('category')],
            ['label' => 'ASC']
        );
        $data = [];
        $data[] = ['value' => '', 'label' => ''];

        foreach ($items as $item) {
            $data[] =  [
                'value' => $item->getId(),
                'label' => $item->getLabel(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/sign/materialSector/edit/itemInfo', name: '_item_info')]
    public function getSignItemData(Request $request, MaterialSectorSignItemRepository $itemRepository): JsonResponse
    {
        $item = $itemRepository->find($request->request->get('itemId'));

        return new JsonResponse(
            [
                'title' => $item->getLabel(),
            ]
        );
    }
}
