<?php

namespace App\Controller\Admin;

use App\Service\Controller\AbstractAppController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractAppController
{
    #[Route('/admin', name: 'admin_home')]
    public function home(): Response
    {
        return $this->render('admin/home.html.twig');
    }
}
