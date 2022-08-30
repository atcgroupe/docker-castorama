<?php

namespace App\EventListener;

use App\Entity\User;
use App\Security\AppAuthenticator;
use App\Service\Member\MemberSessionHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class AppLogoutListener
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly MemberSessionHandler $memberSessionHandler,
    ) {
    }

    public function onLogout(LogoutEvent $event)
    {
        $this->memberSessionHandler->destroy();

        $roles = $event->getToken()->getUser()->getRoles();
        $path = $this->urlGenerator->generate('app_login_choice');

        if (in_array(User::ROLE_CUSTOMER_SHOP, $roles)) {
            $path = $this->urlGenerator->generate('app_login', ['type' => AppAuthenticator::LOGIN_TYPE_CUSTOMER_SHOP]);
        }

        if (in_array(User::ROLE_CUSTOMER_ADMIN, $roles)) {
            $path = $this->urlGenerator->generate('app_login', ['type' => AppAuthenticator::LOGIN_TYPE_CUSTOMER_ADMIN]);
        }

        if (in_array(User::ROLE_COMPANY_ADMIN, $roles)) {
            $path = $this->urlGenerator->generate('app_login', ['type' => AppAuthenticator::LOGIN_TYPE_COMPANY_ADMIN]);
        }

        $event->setResponse(new RedirectResponse($path));
    }
}
