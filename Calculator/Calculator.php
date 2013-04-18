<?php

namespace Msi\StoreBundle\Calculator;

use Msi\StoreBundle\Entity\Order;
use Msi\StoreBundle\Entity\Product;
use Msi\StoreBundle\Entity\Detail;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class Calculator
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    abstract public function getPst();

    abstract public function getGst();

    abstract public function hasShipping(Order $order);

    abstract public function getShipping();

    public function getDetailTotal(Detail $detail)
    {
        return $detail->getProduct()->getPrice() * $detail->getQuantity();
    }

    public function getOrderSubtotal(Order $order)
    {
        $total = 0;
        foreach ($order->getDetails() as $detail) {
            $total += $this->getDetailTotal($detail);
        }

        return $total;
    }

    public function getOrderGst(Order $order)
    {
        $total = 0;
        foreach ($order->getDetails() as $detail) {
            if ($detail->getProduct()->getTaxable()) {
                $total += $this->getDetailTotal($detail) * $this->getGst();
            }
        }

        if ($this->hasShipping($order)) {
            $total += $this->getShipping() * $this->getGst();
        }

        return $total;
    }

    public function getOrderPst(Order $order)
    {
        $total = 0;
        foreach ($order->getDetails() as $detail) {
            if ($detail->getProduct()->getTaxable()) {
                $total += $this->getDetailTotal($detail) * $this->getPst();
            }
        }

        if ($this->hasShipping($order)) {
            $total += $this->getShipping() * $this->getPst();
        }

        return $total;
    }

    public function getOrderTotal(Order $order)
    {
        $subtotal = $this->getOrderSubtotal($order);
        $pst = $this->getOrderPst($order);
        $gst = $this->getOrderGst($order);

        $total = $subtotal + $gst + $pst;

        return $total;
    }
}
