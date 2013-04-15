<?php

namespace Msi\StoreBundle\Doctrine;

use Msi\CmfBundle\Doctrine\Manager as BaseManager;

class ProductManager extends BaseManager
{
    public function findProducts()
    {
        $qb = $this->getFindByQueryBuilder(
            [
                'a.published' => true,
            ]
        );

        return $qb->getQuery()->execute();
    }
}
