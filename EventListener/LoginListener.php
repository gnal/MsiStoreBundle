<?php

namespace Msi\StoreBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;

class LoginListener
{
    protected $user;
    protected $orderManager;

    public function __construct($orderManager)
    {
        $this->orderManager = $orderManager;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $this->user = $event->getAuthenticationToken()->getUser();
        $event->getDispatcher()->addListener(KernelEvents::RESPONSE, [$this, 'onKernelResponse']);
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($request->cookies->has('cao_order_id')) {
            $order = $this->orderManager->findOrderByCookie($request->cookies->get('cao_order_id'));

            if ($order) {
                $old = $this->orderManager->findOrderByUser($this->user);
                if ($old) {
                    $this->orderManager->delete($old);
                }
                $order->setUser($this->user);
                $this->orderManager->update($order);
            }

            $event->getResponse()->headers->clearCookie('cao_order_id');
        }
    }
}
