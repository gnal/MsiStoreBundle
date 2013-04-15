<?php

namespace Msi\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrderController extends Controller
{
    public function showAction()
    {
        $order = $this->container->get('msi_store.provider')->getOrder();

        return $this->render('MsiStoreBundle:Order:show.html.twig', [
            'order' => $order,
            'calculator' => $this->get('msi_store.calculator'),
        ]);
    }
}
