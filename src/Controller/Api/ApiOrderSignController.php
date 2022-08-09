<?php

namespace App\Controller\Api;

use App\Entity\OrderStatus;
use App\Repository\OrderRepository;
use App\Service\Api\OrderSignsDataHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/api/order/{id}', name: 'api_order')]
class ApiOrderSignController extends AbstractController
{
    #[Route('/signs', name: '_signs')]
    public function getSigns(
        int $id,
        OrderRepository $orderRepository,
        OrderSignsDataHelper $signsDataHelper,
        UrlGeneratorInterface $urlGenerator,
        Request $request,
    ): Response {
        if (!$request->isMethod('GET')) {
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

        $order = $orderRepository->find($id);

        if (null === $order) {
            return new JsonResponse(['error' => ['code' => 400, 'message' => "Order $id not found"]], 404);
        }

        # Signs can be downloaded only if the Order has SENT status.
        if ($order->getStatus()->getId() !== OrderStatus::SENT) {
            return new JsonResponse(['error' => ['code' => 400, 'message' => "Order $id has not valid status"]], 400);
        }

        return new BinaryFileResponse($signsDataHelper->generateXmlZipFile($order));
    }
}
