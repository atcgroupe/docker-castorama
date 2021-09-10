<?php

namespace App\Controller\Order\Sign;

use App\Entity\AisleOrderSign;
use App\Entity\SignItem;
use App\Form\AisleOrderSignType;
use App\Repository\AisleOrderSignRepository;
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

            return $form->get('save')->isClicked()
                ? $this->redirectToRoute('orders_view', ['id' => $orderId])
                : $this->redirectToRoute('order_sign_aisle_create', ['orderId' => $orderId]);
        }

        return $this->render(
            'order/sign/aisle/aisle_edit.html.twig',
            [
                'orderId' => $orderId,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/sign/aisle/edit/itemsList', name: '_select_item')]
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

    #[Route('/sign/aisle/edit/itemInfo', name: '_item_info')]
    public function getSignItemData(Request $request, SignItemRepository $itemRepository): JsonResponse
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

    #[Route('/sign/aisle/{id}/update', name: '_update')]
    public function update(int $id, AisleOrderSignRepository $signRepository, Request $request): Response
    {
        $sign = $signRepository->find($id);
        $form = $this->createForm(AisleOrderSignType::class, $sign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            $this->dispatchHtmlAlert(
                Alert::SUCCESS,
                sprintf('Le panneau allée n°%s est modifié!', $sign->getAisleNumber())
            );

            return $form->get('save')->isClicked()
                ? $this->redirectToRoute('orders_view', ['id' => $sign->getOrder()->getId()])
                : $this->redirectToRoute('order_sign_aisle_create', ['orderId' => $sign->getOrder()->getId()]);
        }

        return $this->render(
            'order/sign/aisle/aisle_edit.html.twig',
            [
                'orderId' => $sign->getOrder()->getId(),
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/sign/aisle/{id}/update/quantity', name: '_update_quantity')]
    public function updateQuantity(int $id, Request $request, AisleOrderSignRepository $signRepository): JsonResponse
    {
        $sign = $signRepository->find($id);
        $sign->setQuantity($request->request->get('quantity'));

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(['status' => 'ok']);
    }

    #[Route('/sign/aisle/{id}/delete', name: '_delete')]
    public function delete(int $id, Request $request, AisleOrderSignRepository $signRepository): Response
    {
        $sign = $signRepository->find($id);
        $orderId = $sign->getOrder()->getId();

        if ($request->isMethod('POST')) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($sign);
            $manager->flush();

            $this->dispatchAlert(Alert::SUCCESS, 'Le panneau a été supprimé!');

            return $this->redirectToRoute('orders_view', ['id' => $orderId]);
        }

        return $this->render('order/sign/delete.html.twig', ['sign' => $sign]);
    }
}
