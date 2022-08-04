<?php

namespace App\Controller\Order\Sign;

use App\Entity\AbstractOrderSign;
use App\Entity\Sign;
use App\Form\SignSaveType;
use App\Repository\FixedSignRepository;
use App\Repository\OrderRepository;
use App\Repository\SignRepository;
use App\Service\Alert\Alert;
use App\Service\Controller\AbstractAppController;
use App\Service\Order\OrderHelper;
use App\Service\Order\OrderSignHelper;
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
        private readonly SignRepository $signRepository,
        private readonly FixedSignRepository $fixedSignRepository,
        private readonly OrderHelper    $orderHelper,
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
        $signs = array_merge($variableSigns, $fixedSigns);

        return $this->render('order/sign/choose.html.twig', ['signs' => $signs, 'orderId' => $orderId]);
    }

    #[Route('/{orderId}/sign/{signType}/create', name: '_create')]
    public function create(
        int $orderId,
        string $signType,
        OrderRepository $orderRepository,
        OrderSignHelper $orderSignHelper,
        Request $request,
    ): Response {
        $order = $orderRepository->find($orderId);
        $sign = $this->signRepository->findOneBy(['type' => $signType]);
        $orderSignClass = $sign->getClass();
        $orderSign = new $orderSignClass();
        $orderSign->setOrder($order);
        $form = $this->createForm(sprintf('App\Form\%sOrderSignType', ucfirst($signType)), $orderSign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->orderHelper->updateLastUpdateTime($order);
            $orderSignHelper->createOrderSign($orderSign);

            $this->dispatchAlert(Alert::SUCCESS, 'Le panneau est enregistré!');

            return $this->getRedirectRoute($form, $orderId, $sign);
        }

        return $this->render(
            sprintf('order/sign/%s/edit.html.twig', $signType),
            [
                'orderId' => $orderId,
                'signCategory' => $sign->getCategory(),
                'update' => false,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/sign/{signType}/{id}/update', name: '_update')]
    public function update(string $signType, int $id, Request $request): Response
    {
        $orderSign = $this->getOrderSign($signType, $id);
        $orderId = $orderSign->getOrder()->getId();
        $form = $this->createForm(
            sprintf('App\Form\%sOrderSignType', ucfirst($signType)),
            $orderSign,
            [
                SignSaveType::ACTION_TYPE => SignSaveType::UPDATE
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->orderHelper->updateLastUpdateTime($orderSign->getOrder());

            $this->getDoctrine()->getManager()->flush();

            $this->dispatchAlert(Alert::SUCCESS, 'Les modifications sont enregistrées!');

            return $this->getRedirectRoute($form, $orderId, $orderSign->getSign());
        }

        return $this->render(
            sprintf('order/sign/%s/edit.html.twig', $signType),
            [
                'orderId' => $orderId,
                'signCategory' => $orderSign->getSign()->getCategory(),
                'update' => true,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/sign/{signType}/{id}/update/quantity', name: '_update_quantity')]
    public function updateQuantity(string $signType, int $id, Request $request): JsonResponse
    {
        $orderSign = $this->getOrderSign($signType, $id);
        $orderSign->setQuantity($request->request->get('quantity'));
        $this->orderHelper->updateLastUpdateTime($orderSign->getOrder());

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(['status' => 'ok']);
    }

    #[Route('/sign/{signType}/{id}/delete', name: '_delete')]
    public function delete(string $signType, int $id, Request $request): Response
    {
        $orderSign = $this->getOrderSign($signType, $id);
        $orderId = $orderSign->getOrder()->getId();

        if ($request->isMethod('POST')) {
            $this->orderHelper->updateLastUpdateTime($orderSign->getOrder());
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
     * @param int $orderId
     * @param Sign $sign
     *
     * @return RedirectResponse
     */
    private function getRedirectRoute(FormInterface $form, int $orderId, Sign $sign): RedirectResponse
    {
        $save = $form->get('save');

        if ($save->has('saveAndNew') && $save->get('saveAndNew')->isClicked()) {
            return $this->redirectToRoute(
                'order_sign_create',
                [
                    'orderId' => $orderId,
                    'signType' => $sign->getType()
                ]
            );
        }

        if ($save->has('saveAndChoose') && $save->get('saveAndChoose')->isClicked()) {
            return $this->redirectToRoute(
                'order_sign_choose',
                [
                    'orderId' => $orderId,
                    'category' => $sign->getCategory()
                ]
            );
        }

        return $this->redirectToRoute('orders_view', ['id' => $orderId]);
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
