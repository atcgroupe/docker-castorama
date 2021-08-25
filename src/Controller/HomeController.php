<?php

namespace App\Controller;

use App\Service\Controller\AbstractAppController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractAppController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('home/home.html.twig');
    }
}
