<?php

namespace App\Controller\Order\Sign;

use App\Entity\FixedOrderSign;
use App\Form\FixedOrderSignType;
use App\Repository\FixedOrderSignRepository;
use App\Repository\FixedSignRepository;
use App\Repository\OrderRepository;
use App\Service\Alert\Alert;
use App\Service\Controller\AbstractAppController;
use App\Service\Order\OrderHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order', name: 'fixed_order_sign')]
class FixedOrderSignController extends AbstractAppController
{
    public function __construct(
        private readonly FixedSignRepository $signRepository,
        private readonly FixedOrderSignRepository $orderSignRepository,
        private readonly OrderRepository $orderRepository,
        private readonly OrderHelper $orderHelper,
    ) {
    }

    #[Route('/{orderId}/fixedSign/{signId}/create', name: '_create')]
    public function create(int $orderId, int $signId, Request $request): Response
    {
        $sign = $this->signRepository->find($signId);
        $order = $this->orderRepository->find($orderId);
        $orderSign = new FixedOrderSign();
        $orderSign->setOrder($order);
        $orderSign->setFixedSign($sign);
        $form = $this->createForm(FixedOrderSignType::class, $orderSign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $this->orderHelper->updateLastUpdateTime($orderSign->getOrder());
            $manager->persist($orderSign);
            $manager->flush();

            $this->dispatchAlert(Alert::SUCCESS, 'Le panneau est enregistré!');

            return $this->redirectToRoute('orders_view', ['id' => $orderId]);
        }

        return $this->render(
            'order/sign/fixed/edit.html.twig',
            [
                'form' => $form->createView(),
                'sign' => $sign,
                'orderId' => $orderId,
            ]
        );
    }

    #[Route('/fixedSign/{id}/update', name: '_update')]
    public function update(int $id, Request $request): Response
    {
        $orderSign = $this->orderSignRepository->find($id);
        $form = $this->createForm(FixedOrderSignType::class, $orderSign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->orderHelper->updateLastUpdateTime($orderSign->getOrder());
            $this->getDoctrine()->getManager()->flush();

            $this->dispatchAlert(Alert::SUCCESS, 'La quantité a été modifiée!');

            return $this->redirectToRoute('orders_view', ['id' => $orderSign->getOrderId()]);
        }

        return $this->render(
            'order/sign/fixed/edit.html.twig',
            [
                'form' => $form->createView(),
                'sign' => $orderSign->getFixedSign(),
                'orderId' => $orderSign->getOrderId(),
                'orderSign' => $orderSign,
            ]
        );
    }

    #[Route('/fixedSign/{id}/update/quantity', name: '_update_quantity')]
    public function updateQuantity(int $id, Request $request): JsonResponse
    {
        $orderSign = $this->orderSignRepository->find($id);
        $orderSign->setQuantity($request->request->get('quantity'));
        $this->orderHelper->updateLastUpdateTime($orderSign->getOrder());

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(['status' => 'ok']);
    }

    #[Route('/fixedSign/{id}/delete', name: '_delete')]
    public function delete(int $id, Request $request): Response
    {
        $orderSign = $this->orderSignRepository->find($id);

        if ($request->isMethod('POST')) {
            $this->orderHelper->updateLastUpdateTime($orderSign->getOrder());
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($orderSign);
            $manager->flush();

            $this->dispatchAlert(Alert::SUCCESS, 'Le panneau a été supprimé!');

            return $this->redirectToRoute('orders_view', ['id' => $orderSign->getOrderId()]);
        }

        return $this->render('order/sign/delete.html.twig', ['sign' => $orderSign]);
    }
}
