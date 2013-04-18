<?php

namespace Msi\StoreBundle\Doctrine;

use Msi\CmfBundle\Doctrine\Manager as BaseManager;

class ProductManager extends BaseManager
{
    public function getFindProductsQueryBuilder()
    {
        $qb = $this->getFindByQueryBuilder(
            [
                'a.published' => true,
            ],
            [
                'a.category' => 'c',
            ]
        );

        return $qb;
    }
}
