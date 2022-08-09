<?php

namespace App\Controller\Order\Sign;

use App\Entity\AbstractOrderSign;
use App\Entity\Sign;
use App\Form\SignSaveType;
use App\Repository\OrderRepository;
use App\Repository\SignCategoryRepository;
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
        private readonly OrderHelper $orderHelper,
        private readonly SignCategoryRepository $categoryRepository,
    ) {
    }

    #[Route('/{orderId}/sign/choose-category', name: '_choose_category')]
    public function chooseCategory(int $orderId): Response
    {
        return $this->render(
            'order/sign/choose_category.html.twig',
            [
                'orderId' => $orderId,
                'categories' => $this->categoryRepository->findAll(),
            ]
        );
    }

    #[Route('/{orderId}/sign/{categoryId}/choose', name: '_choose')]
    public function choose(int $orderId, int $categoryId): Response
    {
        $category = $this->categoryRepository->find($categoryId);
        $signs = $this->signRepository->findBy(['isActive' => true, 'category' => $category]);

        return $this->render(
            'order/sign/choose.html.twig',
            [
                'orderId' => $orderId,
                'signs' => $signs,
            ]
        );
    }

    #[Route('/{orderId}/sign/{name}/create', name: '_create')]
    public function create(
        int $orderId,
        string $name,
        OrderRepository $orderRepository,
        OrderSignHelper $orderSignHelper,
        Request $request,
    ): Response {
        $order = $orderRepository->find($orderId);
        $sign = $this->signRepository->findOneBy(['name' => $name]);
        $orderSignClass = $sign->getClass();
        $orderSign = new $orderSignClass($order, $sign);
        $form = $this->createForm(sprintf('App\Form\%sOrderSignType', ucfirst($sign->getType())), $orderSign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->orderHelper->updateLastUpdateTime($order);
            $orderSignHelper->createOne($orderSign);

            $this->dispatchAlert(Alert::SUCCESS, 'Le panneau est enregistré!');

            return $this->getRedirectRoute($form, $orderId, $sign);
        }

        return $this->render(
            sprintf('order/sign/%s/edit.html.twig', $sign->getType()),
            [
                'orderId' => $orderId,
                'sign' => $sign,
                'signCategory' => $sign->getCategory(),
                'update' => false,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/sign/{name}/{id}/update', name: '_update')]
    public function update(string $name, int $id, Request $request): Response
    {
        $orderSign = $this->getOrderSign($name, $id);
        $orderId = $orderSign->getOrder()->getId();
        $form = $this->createForm(
            sprintf('App\Form\%sOrderSignType', ucfirst($orderSign->getSign()->getType())),
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
            sprintf('order/sign/%s/edit.html.twig', $orderSign->getSign()->getType()),
            [
                'orderId' => $orderId,
                'signCategory' => $orderSign->getSign()->getCategory(),
                'update' => true,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/sign/{name}/{id}/update/quantity', name: '_update_quantity')]
    public function updateQuantity(string $name, int $id, Request $request): JsonResponse
    {
        $orderSign = $this->getOrderSign($name, $id);
        $orderSign->setQuantity($request->request->get('quantity'));
        $this->orderHelper->updateLastUpdateTime($orderSign->getOrder());

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(['status' => 'ok']);
    }

    #[Route('/sign/{name}/{id}/delete', name: '_delete')]
    public function delete(string $name, int $id, Request $request): Response
    {
        $orderSign = $this->getOrderSign($name, $id);
        $orderId = $orderSign->getOrder()->getId();

        if ($request->isMethod('POST')) {
            $this->orderHelper->updateLastUpdateTime($orderSign->getOrder());
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($orderSign);
            $manager->flush();

            $this->dispatchAlert(Alert::SUCCESS, 'Le panneau a été supprimé!');

            return $this->redirectToRoute('orders_view', ['id' => $orderId]);
        }

        return $this->render('order/sign/delete.html.twig', ['sign' => $orderSign,]);
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
        $saveAndNewRoute = $this->redirectToRoute(
            'order_sign_create',
            [
                'orderId' => $orderId,
                'name' => $sign->getName(),
            ]
        );

        $saveAndChooseRoute = $this->redirectToRoute(
            'order_sign_choose',
            [
                'orderId' => $orderId,
                'categoryId' => $sign->getCategory()->getId(),
            ]
        );

        if ($sign->isCustomType()) {
            return $saveAndChooseRoute;
        }

        $save = $form->get('save');

        if ($save->has('saveAndNew') && $save->get('saveAndNew')->isClicked()) {
            return $saveAndNewRoute;
        }

        if ($save->has('saveAndChoose') && $save->get('saveAndChoose')->isClicked()) {
            return $saveAndChooseRoute;
        }

        return $this->redirectToRoute('orders_view', ['id' => $orderId]);
    }

    /**
     * @param string $signName
     * @param int    $id
     *
     * @return AbstractOrderSign
     */
    private function getOrderSign(string $signName, int $id): AbstractOrderSign
    {
        $manager = $this->getDoctrine()->getManager();
        $sign = $this->signRepository->findOneBy(['name' => $signName]);

        return $manager->getRepository($sign->getClass())->find($id);
    }
}
