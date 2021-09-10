<?php

namespace App\Controller\Order\Sign;

use App\Entity\AisleOrderSign;
use App\Entity\SignItem;
use App\Form\AisleOrderSignType;
use App\Repository\OrderRepository;
use App\Repository\SignItemRepository;
use App\Service\Alert\Alert;
use App\Service\Controller\AbstractAppController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order', name: 'order_sign_aisle')]
class OrderSignAisleController extends AbstractAppController
{
    #[Route('/{orderId}/sign/aisle/create', name: '_create')]
    public function create(int $orderId, OrderRepository $orderRepository, Request $request): Response
    {
        $sign = new AisleOrderSign();
        $sign->setOrder($orderRepository->find($orderId));
        $form = $this->createForm(AisleOrderSignType::class, $sign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($sign);
            $manager->flush();

            $this->dispatchHtmlAlert(
                Alert::SUCCESS,
                sprintf('Le panneau allée n°%s est enregistré!', $sign->getAisleNumber())
            );

            return $this->redirectToRoute('orders_view', ['id' => $orderId]);
        }

        return $this->render(
            'order/sign/aisle/aisle_edit.html.twig',
            [
                'orderId' => $orderId,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/sign/aisle/create/items/list', name: '_select_item')]
    public function setSignItemsFromCategory(Request $request, SignItemRepository $itemRepository): JsonResponse
    {
        $categoryId = $request->request->get('category');
        $items = $itemRepository->findBy(['category' => $categoryId]);
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

    #[Route('/sign/aisle/create/item/image', name: '_item_image')]
    public function getSignItemImage(Request $request, SignItemRepository $itemRepository): JsonResponse
    {
        $itemId = $request->request->get('itemId');
        $item = ($itemId !== '') ?
            $itemRepository->find($itemId) :
            (new SignItem())->setImage('empty')->setLabel('')
        ;

        return new JsonResponse(
            [
                'name' => sprintf('/build/images/sign/sign/aisle/picto/%s.svg', $item->getImage()),
                'title' => $item->getLabel(),
            ]
        );
    }
}
