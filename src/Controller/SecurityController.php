<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Member\MemberSessionHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login_choice')]
    public function loginChoice(): Response
    {
        return $this->render('security/login_choice.html.twig');
    }

    #[Route('/login/{type}', name: 'app_login', requirements: ['type' => 'shop|admin|atc'])]
    public function login(
        string $type,
        AuthenticationUtils $authenticationUtils,
        MemberSessionHandler $memberSessionHandler,
    ): Response {
        $memberSessionHandler->destroy();

        $templateData = [
            'type' => $type,
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ];

        if ($type === 'shop') {
            $manager = $this->getDoctrine()->getManager();
            $templateData['shopUsers'] = $manager->getRepository(User::class)->findShopsUsers();
            $templateData['last_username'] = $authenticationUtils->getLastUsername();
        }

        return $this->render('security/login.html.twig', $templateData);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
    }
}
