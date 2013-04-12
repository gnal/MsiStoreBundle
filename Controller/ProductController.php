<?php

namespace Msi\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function indexAction()
    {
        $qb = $this->container->get('msi_store.product_manager')->getFindByQueryBuilder();

        $products = $qb->getQuery()->execute();

        return $this->render('MsiStoreBundle:Product:index.html.twig', ['products' => $products]);
    }
}
