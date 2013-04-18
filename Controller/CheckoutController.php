<?php

namespace Msi\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CheckoutController extends Controller
{
    public function reviewAction()
    {
        return $this->render('MsiStoreBundle:Checkout:review.html.twig', [
            'calculator' => $this->get('msi_store.calculator'),
        ]);
    }

    public function paymentAction()
    {
        return $this->render('MsiStoreBundle:Checkout:payment.html.twig');
    }
}
