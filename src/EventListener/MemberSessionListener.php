<?php

namespace App\EventListener;

use App\Controller\MemberController;
use App\Service\Member\MemberSessionHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Member security manager
 *
 * A member has to be selected to navigate in the app.
 */
class MemberSessionListener
{
    public function __construct(
        private Security $security,
        private UrlGeneratorInterface $urlGenerator,
        private MemberSessionHandler $memberSessionHandler,
    ){
    }

    public function onKernelRequest(RequestEvent $event)
    {
        // No user is authenticated.
        if ($this->security->getUser() === null) {
            return;
        }

        // Member has been selected.
        if ($this->security->getToken()->isAuthenticated() && $this->memberSessionHandler->has()) {
            return;
        }

        $redirectRoute = $this->urlGenerator->generate('member_choose');
        $authorizedRoute = $this->urlGenerator->generate('member_create');
        $pathInfo = $event->getRequest()->getPathInfo();

        if (
            $pathInfo !== $redirectRoute &&
            $pathInfo !== $authorizedRoute &&
            !str_starts_with($pathInfo, MemberController::MEMBER_SELECT_ROUTE_PREFIX)
        ) {
            $event->setResponse(new RedirectResponse($redirectRoute));
        }
    }
}
