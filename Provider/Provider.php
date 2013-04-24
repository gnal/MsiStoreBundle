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
            if ($this->getUser()) {
                $this->order = $this->getOrderManager()->findOrderByUser($this->getUser());
            } else {
                $this->order = $this->getOrderManager()->findOrderByCookie($this->container->get('request')->cookies->get('order_id'));
            }

            if (!$this->order) {
                $this->order = $this->getOrderManager()->create();
                if ($this->getUser()) {
                    $this->order->setUser($this->getUser());
                    $this->getOrderManager()->update($this->order);
                } else{
                    $this->getOrderManager()->update($this->order);
                    $this->container->get('event_dispatcher')->addListener(KernelEvents::RESPONSE, [$this->container->get('msi_store.cookie_listener'), 'onKernelResponse']);
                }
            }
        }

        return $this->order;
    }

    private function getUser()
    {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.context')->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            return null;
        }

        return $user;
    }

    private function getOrderManager()
    {
        return $this->container->get('msi_store.order_manager');
    }
}
