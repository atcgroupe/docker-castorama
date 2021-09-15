<?php

namespace App\Controller\Order\Sign;

use App\Entity\AbstractOrderSign;
use App\Repository\OrderRepository;
use App\Repository\SignRepository;
use App\Service\Alert\Alert;
use App\Service\Controller\AbstractAppController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order', name: 'order_sign')]
class OrderSignController extends AbstractAppController
{
    public function __construct(
        private SignRepository $signRepository,
    ) {
    }

    #[Route('/{orderId}/sign/choose', name: '_choose')]
    public function choose(int $orderId, SignRepository $signRepository): Response
    {
        $signs = $signRepository->findAll();

        return $this->render('order/sign/choose.html.twig', ['signs' => $signs, 'orderId' => $orderId]);
    }

    #[Route('/{orderId}/sign/{signType}/create', name: '_create')]
    public function create(int $orderId, string $signType, OrderRepository $orderRepository, Request $request): Response
    {
        $orderSignClass = $this->signRepository->findOneBy(['type' => $signType])->getClass();
        $orderSign = new $orderSignClass();
        $orderSign->setOrder($orderRepository->find($orderId));
        $form = $this->createForm(sprintf('App\Form\%sOrderSignType', ucfirst($signType)), $orderSign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($orderSign);
            $manager->flush();

            $this->dispatchAlert(Alert::SUCCESS, 'Le panneau est enregistré!');

            return $this->getRedirectRoute($form, $orderId, $signType);
        }

        return $this->render(
            sprintf('order/sign/%s/edit.html.twig', $signType),
            [
                'orderId' => $orderId,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/sign/{signType}/{id}/update', name: '_update')]
    public function update(string $signType, int $id, Request $request): Response
    {
        $orderSign = $this->getOrderSign($signType, $id);
        $orderId = $orderSign->getOrder()->getId();
        $form = $this->createForm(sprintf('App\Form\%sOrderSignType', ucfirst($signType)), $orderSign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($orderSign);
            $manager->flush();

            $this->dispatchAlert(Alert::SUCCESS, 'Les modifications sont enregistrées!');

            return $this->getRedirectRoute($form, $orderId, $signType);
        }

        return $this->render(
            sprintf('order/sign/%s/edit.html.twig', $signType),
            [
                'orderId' => $orderId,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/sign/{signType}/{id}/update/quantity', name: '_update_quantity')]
    public function updateQuantity(string $signType, int $id, Request $request): JsonResponse
    {
        $orderSign = $this->getOrderSign($signType, $id);
        $orderSign->setQuantity($request->request->get('quantity'));

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(['status' => 'ok']);
    }

    #[Route('/sign/{signType}/{id}/delete', name: '_delete')]
    public function delete(string $signType, int $id, Request $request): Response
    {
        $orderSign = $this->getOrderSign($signType, $id);
        $orderId = $orderSign->getOrder()->getId();

        if ($request->isMethod('POST')) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($orderSign);
            $manager->flush();

            $this->dispatchAlert(Alert::SUCCESS, 'Le panneau a été supprimé!');

            return $this->redirectToRoute('orders_view', ['id' => $orderId]);
        }

        return $this->render('order/sign/delete.html.twig', ['sign' => $orderSign]);
    }

    /**
     * @param FormInterface $form
     * @param               $orderId
     * @param               $signType
     *
     * @return RedirectResponse
     */
    private function getRedirectRoute(FormInterface $form, $orderId, $signType): RedirectResponse
    {
        return $form->get('save')->isClicked()
            ? $this->redirectToRoute('orders_view', ['id' => $orderId])
            : $this->redirectToRoute('order_sign_create', ['orderId' => $orderId, 'signType' => $signType]);
    }

    /**
     * @param string $signType
     * @param int    $id
     *
     * @return AbstractOrderSign
     */
    private function getOrderSign(string $signType, int $id): AbstractOrderSign
    {
        $manager = $this->getDoctrine()->getManager();
        $sign = $this->signRepository->findOneBy(['type' => $signType]);
        return $manager->getRepository($sign->getClass())->find($id);
    }
}
