<?php

namespace App\Controller\Order\Sign;

use App\Entity\AisleSignItem;
use App\Repository\AisleSignItemRepository;
use App\Service\Controller\AbstractAppController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order', name: 'order_sign_aisle')]
class AisleOrderSignController extends AbstractAppController
{
    #[Route('/sign/aisle/edit/itemsList', name: '_select_item')]
    public function setSignItemsFromCategory(Request $request, AisleSignItemRepository $itemRepository): JsonResponse
    {
        $categoryId = $request->request->get('category');
        $items = $itemRepository->findBy(['category' => $categoryId], ['label' => 'ASC']);
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

    #[Route('/sign/aisle/edit/itemInfo', name: '_item_info')]
    public function getSignItemData(Request $request, AisleSignItemRepository $itemRepository): JsonResponse
    {
        $itemId = $request->request->get('itemId');
        $hideImage = $request->request->get('hideImage') === 'true';

        $item = ($itemId !== '' && !$hideImage) ?
            $itemRepository->find($itemId) :
            (new AisleSignItem())->setImage('empty')->setLabel('')
        ;

        return new JsonResponse(
            [
                'name' => sprintf('/build/images/sign/sign/aisle/picto/%s.svg', $item->getImage()),
                'title' => $item->getLabel(),
            ]
        );
    }
}
