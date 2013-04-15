<?php

namespace Msi\StoreBundle\Provider;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class Provider
{
    private $container;
    private $order;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->order = null;
    }

    public function getOrder()
    {
        if (!$this->order) {
            if (is_object($this->getUser())) {
                $this->order = $this->getOrderManager()->findOrderByUser($this->getUser());
            } else {
                $this->order = $this->getOrderManager()->findOrderByCookie($this->container->get('request')->cookies->get('cao_order_id'));
            }

            if (!$this->order) {
                $this->order = $this->getOrderManager()->create();
                $this->getOrderManager()->update($this->order);
                if (is_object($this->getUser())) {
                    $this->order->setUser($this->getUser());
                } else{
                    $this->container->get('event_dispatcher')->addListener(KernelEvents::RESPONSE, [$this->container->get('msi_store.cookie_listener'), 'onKernelResponse']);
                }
            }
        }

        return $this->order;
    }

    private function getUser()
    {
        if (is_object($this->container->get('security.context')->getToken())) {
            return $this->container->get('security.context')->getToken()->getUser();
        }

        return null;
    }

    private function getOrderManager()
    {
        return $this->container->get('msi_store.order_manager');
    }
}
