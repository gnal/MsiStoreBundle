<?php

namespace Msi\StoreBundle\Provider;

use Symfony\Component\DependencyInjection\ContainerInterface;

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
            $sc = $this->container->get('security.context');
            $user = $sc->getToken()->getUser();
            $orderManager = $this->container->get('msi_store.order_manager');

            if ($sc->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                $qb = $orderManager->getFindByQueryBuilder(
                    [
                        'a.user' => $user,
                    ]
                );

                $qb->andWhere($qb->expr()->isNull('a.frozenAt'));

                $this->order = $qb->getQuery()->getOneOrNullResult();
            }

            if (!$this->order) {
                $this->order = $orderManager->create();
                $this->order->setUser($user);
            }
        }

        return $this->order;
    }
}
