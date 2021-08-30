<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderRegistrationType;
use App\Service\Alert\Alert;
use App\Service\Controller\AbstractAppController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/orders', name: 'orders')]
class OrderController extends AbstractAppController
{
    #[Route('/create', name: '_create')]
    public function create(Request $request)
    {
        $order = new Order();

        $form = $this->createForm(OrderRegistrationType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($order);
            $manager->flush();

            $this->dispatchHtmlAlert(
                Alert::INFO,
                'Votre commande est créée. Vous pouvez maintenant ajouter des panneaux!'
            );

            return $this->redirectToRoute('orders_list_active');
        }

        return $this->render('order/create.html.twig', ['form' => $form->createView()]);
    }
}
