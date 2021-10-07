<?php

namespace App\Controller\Api;

use App\Entity\OrderStatus;
use App\Repository\OrderRepository;
use App\Service\Order\OrderSignHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use ZipArchive;

#[Route('/api/order/{id}', name: 'api_order')]
class ApiOrderSignController extends AbstractController
{
    #[Route('/signs', name: '_signs')]
    public function getSigns(
        int $id,
        OrderRepository $orderRepository,
        OrderSignHelper $signHelper,
        UrlGeneratorInterface $urlGenerator,
        SerializerInterface $serializer,
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

        if ($order->getStatus()->getId() !== OrderStatus::RECEIVED) {
            return new JsonResponse(['error' => ['code' => 400, 'message' => "Order $id has not valid status"]], 400);
        }

        $signsByType = $signHelper->findOrderSigns($order);
        $zip = new ZipArchive();
        $zipName = 'api/order.zip';
        if (is_readable($zipName)) {
            unlink($zipName);
        }
        $zip->open($zipName, ZipArchive::CREATE);

        foreach ($signsByType as $typeSigns) {
            foreach ($typeSigns as $sign) {
                $sign->setData($serializer->serialize($sign, 'json', ['groups' => 'api_json_data']));
                $zip->addFromString(
                    $sign->getFileName(),
                    $serializer->serialize(
                        $sign,
                        'xml',
                        [
                            'groups' => 'api_xml_object',
                            'xml_format_output' => true,
                            'xml_encoding' => 'utf-8',
                            'xml_root_node_name' => 'sign'
                        ]
                    )
                );
            }
        }

        $zip->close();

        return new BinaryFileResponse($zipName);
    }
}
