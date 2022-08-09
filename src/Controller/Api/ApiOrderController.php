<?php

namespace App\Controller\Api;

use App\Repository\OrderRepository;
use App\Repository\OrderStatusRepository;
use App\Service\Order\OrderHelper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/order/{id}', name: 'api_order')]
class ApiOrderController extends AbstractController
{
    #[Route('/status', name: '_status')]
    public function setStatus(
        int $id,
        Request $request,
        OrderRepository $orderRepository,
        OrderHelper $orderHelper,
        SerializerInterface $serializer,
        OrderStatusRepository $orderStatusRepository,
        UrlGeneratorInterface $urlGenerator,
        ManagerRegistry $doctrine,
    ): JsonResponse {
        $order = $orderRepository->find($id);
        $statusId = $request->request->get('statusId');

        if (!$request->isMethod('PATCH')) {
            return new JsonResponse(
                [
                    'error' => [
                        'code' => 404,
                        'message' => sprintf(
                            'No route found for %s route with %s method.',
                            $urlGenerator->generate('api_order_status', ['id' => $id]),
                            $request->getMethod()
                        )
                    ]
                ],
                404
            );
        }

        if (null === $order) {
            return new JsonResponse(['error' => ['code' => 400, 'message' => "Order $id not found"]], 404);
        }

        if (null === $orderStatusRepository->find($statusId)) {
            return new JsonResponse(['error' => ['code' => 400, 'message' => 'Status id not found']], 400);
        }

        $orderHelper->setOrderStatus($order, $statusId);
        $doctrine->getManager()->flush();

        return new JsonResponse(
            $serializer->serialize($order, 'json', ['groups' => 'api']),
            200,
            [],
            true
        );
    }
}
