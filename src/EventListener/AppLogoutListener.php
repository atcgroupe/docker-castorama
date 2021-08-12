<?php

namespace App\EventListener;

use App\Entity\User;
use App\Security\AppAuthenticator;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\Security\Http\HttpUtils;

class AppLogoutListener
{
    public function __construct(
        private HttpUtils $httpUtils,
    ) {
    }

    public function onLogout(LogoutEvent $event)
    {
        $roles = $event->getToken()->getUser()->getRoles();

        $path = '/login/';

        if (in_array(User::ROLE_CUSTOMER_SHOP, $roles)) {
            $path .= AppAuthenticator::LOGIN_TYPE_CUSTOMER_SHOP;
        }

        if (in_array(User::ROLE_CUSTOMER_ADMIN, $roles)) {
            $path .= AppAuthenticator::LOGIN_TYPE_CUSTOMER_ADMIN;
        }

        if (in_array(User::ROLE_COMPANY_ADMIN, $roles)) {
            $path .= AppAuthenticator::LOGIN_TYPE_COMPANY_ADMIN;
        }

        $event->setResponse($this->httpUtils->createRedirectResponse($event->getRequest(), $path));
    }
}
