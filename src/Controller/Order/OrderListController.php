<?php

namespace App\Controller\Order;

use App\Entity\OrderStatus;
use App\Entity\User;
use App\Repository\OrderRepository;
use App\Repository\OrderStatusRepository;
use App\Repository\UserRepository;
use App\Service\Controller\AbstractAppController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/orders/list', name: 'orders_list')]
class OrderListController extends AbstractAppController
{
    private const SHOP_USER_FILTER_ALL = 'all';

    public function __construct(
        private OrderRepository $orderRepository,
        private UserRepository $userRepository,
    ) {
    }

    #[Route('/{shopUserFilter}/active', name: '_active')]
    public function list(string $shopUserFilter = self::SHOP_USER_FILTER_ALL): Response {
        $isActive = true;
        $isShop = $this->isShopUser();
        $shopUser = $this->getShopUser($shopUserFilter);
        $orders = $this->orderRepository->findWithRelations($isActive, $this->isCustomerUser(), $shopUser);

        $templateData = [
            'orders' => $orders,
            'isShop' => $isShop,
            'isActive' => $isActive,
            'shopUserFilter' => $shopUserFilter,
            'search' => null,
        ];

        if (!$isShop) {
            $templateData['shopUsers'] = $this->userRepository->findShopsUsers();
        }

        return $this->render('order/list.html.twig', $templateData);
    }

    #[Route('/{shopUserFilter}/archives/{page}', name: '_archives', requirements: ['page' => '[0-9]*'])]
    public function listArchives(
        int $page,
        OrderStatusRepository $orderStatusRepository,
        Request $request,
        string $shopUserFilter = self::SHOP_USER_FILTER_ALL,
    ): Response {
        $isShop = $this->isShopUser();
        $isActive = false;
        $shopUser = $this->getShopUser($shopUserFilter);
        $search = null;

        if ($request->isMethod('POST')) {
            $data = trim($request->request->get('search'));
            $search = ($data !== '') ? $data : null;
        }

        $orders = $this->orderRepository->findWithRelations($isActive, $isShop, $shopUser, $page, $search);

        $countCriteria = ['status' => $orderStatusRepository->find(OrderStatus::DELIVERED)];
        if ($isShop) {
            $countCriteria['user'] = $shopUser;
        }
        $totalOrders = (null === $search) ? $this->orderRepository->count($countCriteria) : count($orders);
        $count = ceil($totalOrders / OrderRepository::ITEMS_PER_PAGES);

        $templateData = [
            'orders' => $orders,
            'isShop' => $isShop,
            'isActive' => $isActive,
            'shopUserFilter' => $shopUserFilter,
            'page' => $page,
            'count' => $count,
            'search' => $search,
        ];

        if (!$isShop) {
            $templateData['shopUsers'] = $this->userRepository->findShopsUsers();
        }

        return $this->render('order/list.html.twig', $templateData);
    }

    /**
     * @param string $shopUserFilter
     *
     * @return User|null
     */
    private function getShopUser(string $shopUserFilter): User | null
    {
        if ($this->isShopUser()) {
            return $this->getUser();
        }

        if ($shopUserFilter !== self::SHOP_USER_FILTER_ALL) {
            return $this->userRepository->find($shopUserFilter);
        }

        return null;
    }
}
