<?php

namespace Msi\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrderController extends Controller
{
    public function showAction()
    {
        return $this->render('MsiStoreBundle:Order:show.html.twig', [
            'calculator' => $this->get('msi_store.calculator'),
        ]);
    }
}
