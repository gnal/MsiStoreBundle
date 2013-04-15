<?php

namespace Msi\StoreBundle\Doctrine;

use Msi\CmfBundle\Doctrine\Manager as BaseManager;

class OrderManager extends BaseManager
{
    public function findOrderByCookie($cookie)
    {
        $qb = $this->getFindByQueryBuilder(
            [
                'a.id' => $cookie,
            ]
        );

        $qb->andWhere($qb->expr()->isNull('a.user'));
        $qb->andWhere($qb->expr()->isNull('a.frozenAt'));

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findOrderByUser($user)
    {
        $qb = $this->getFindByQueryBuilder(
            [
                'a.user' => $user,
            ]
        );

        $qb->andWhere($qb->expr()->isNull('a.frozenAt'));

        return $qb->getQuery()->getOneOrNullResult();
    }
}
