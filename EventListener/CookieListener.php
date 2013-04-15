<?php

namespace Msi\StoreBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Cookie;

class CookieListener
{
    protected $provider;

    public function __construct($provider)
    {
        $this->provider = $provider;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $event->getResponse()->headers->setCookie(new Cookie('cao_order_id', $this->provider->getOrder()->getId()));
    }
}
