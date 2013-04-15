<?php

namespace Msi\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function indexAction()
    {
        $products = $this->get('msi_store.product_manager')->findProducts();

        return $this->render('MsiStoreBundle:Product:index.html.twig', ['products' => $products]);
    }

    public function showAction()
    {
        $product = $this->container->get('msi_store.product_manager')->getOneBy([
            'a.id' => $this->getRequest()->attributes->get('id'),
            'a.published' => true,
        ]);

        return $this->render('MsiStoreBundle:Product:show.html.twig', ['product' => $product]);
    }
}
