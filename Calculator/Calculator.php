<?php

namespace Msi\StoreBundle\Calculator;

use Msi\StoreBundle\Entity\Order;
use Msi\StoreBundle\Entity\Product;
use Msi\StoreBundle\Entity\Detail;

use Symfony\Component\DependencyInjection\ContainerInterface;

class Calculator
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getDetailTotal(Detail $detail)
    {
        return $detail->getProduct()->getPrice() * $detail->getQuantity();
    }

    // public function getOrderSubTotal(Order $order)
    // {
    //     $total = 0;
    //     foreach ($order->getDetails() as $detail) {
    //         $total += $this->getOrderDetailTotal($detail);
    //     }

    //     return $total;
    // }

    // public function getOrderTotal(Order $order)
    // {
    //     $provider = $this->container->get('cao_app.provider');

    //     $gst = $provider->getSetting('gst')->getValue();
    //     $pst = $provider->getSetting('pst')->getValue();

    //     $total = 0;
    //     foreach ($order->getDetails() as $detail) {
    //         if ($detail->getProduct()->getTaxable()) {
    //             $total += $this->getOrderDetailTotal($detail) * (1 + $gst + $pst);
    //         } else {
    //             $total += $this->getOrderDetailTotal($detail);
    //         }
    //     }

    //     if ($this->hasShipping($order)) {
    //         $total += $provider->getSetting('shipping')->getValue() * (1 + $gst + $pst);
    //     }

    //     return $total;
    // }

    // public function getOrderGst(Order $order)
    // {
    //     $provider = $this->container->get('cao_app.provider');

    //     $gst = $provider->getSetting('gst')->getValue();

    //     $total = 0;
    //     foreach ($order->getDetails() as $detail) {
    //         if ($detail->getProduct()->getTaxable()) {
    //             $total += $this->getOrderDetailTotal($detail) * $gst;
    //         }
    //     }

    //     if ($this->hasShipping($order)) {
    //         $total += $provider->getSetting('shipping')->getValue() * $gst;
    //     }

    //     return $total;
    // }

    // public function getOrderPst(Order $order)
    // {
    //     $provider = $this->container->get('cao_app.provider');

    //     $pst = $provider->getSetting('pst')->getValue();

    //     $total = 0;
    //     foreach ($order->getDetails() as $detail) {
    //         if ($detail->getProduct()->getTaxable()) {
    //             $total += $this->getOrderDetailTotal($detail) * $pst;
    //         }
    //     }

    //     if ($this->hasShipping($order)) {
    //         $total += $provider->getSetting('shipping')->getValue() * $pst;
    //     }

    //     return $total;
    // }

    // public function getOrderDetailTotal(OrderDetail $detail)
    // {
    //     return $this->getInflatedBoxPrice($detail->getProduct()) * $detail->getQuantity();
    // }

    // public function getInflatedBoxPrice(Product $product)
    // {
    //     $user = $this->container->get('security.context')->getToken()->getUser();

    //     // si le produit est en vente
    //     if ($product->getSaleBoxPrice()) {
    //         $total = $product->getSaleBoxPrice();
    //     // sinon si le client a une liste de prix (ce qui devrait tjrs etre le cas apart pour genre un admin)
    //     } elseif ($user->getPriceList()) {
    //         $total = $product->getBoxPrice() * (1 + $user->getPriceList()->getValue());
    //     } else {
    //         $total = $product->getBoxPrice();
    //     }

    //     return $total;
    // }

    // public function hasShipping(Order $order)
    // {
    //     $provider = $this->container->get('cao_app.provider');

    //     return $this->getOrderSubTotal($order) <= $provider->getSetting('prix_min_commande')->getValue();
    // }
}
