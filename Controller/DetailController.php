<?php

namespace Msi\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DetailController extends Controller
{
    public function newAction()
    {
        $order = $this->container->get('msi_store.provider')->getOrder();
        $product = $this->container->get('msi_store.product_manager')->getOneBy(
            [
                'a.id' => $this->getRequest()->request->get('productId'),
                'a.published' => true,
            ]
        );

        // check if the order already has this product
        foreach ($order->getDetails() as $element) {
            if ($element->getProduct()->getId() === $product->getId()) {
                $detail = $element;
            }
        }

        if (!empty($detail)) {
            $detail->setQuantity($detail->getQuantity() + $this->getRequest()->request->get('quantity'));
        } else {
            $detail = $this->get('msi_store.detail_manager')->create();
            $detail->setProduct($product);
            $detail->setPrice($product->getPrice());
            $detail->setName($product->getTranslation()->getName());
            $detail->setQuantity($this->getRequest()->request->get('quantity'));
            $detail->setOrder($order);
            $order->getDetails()->add($detail);
        }

        if ($detail->getQuantity() > 999) {
            $detail->setQuantity(999);
        }

        if ($detail->getQuantity() < 1) {
            $detail->setQuantity(1);
        }

        $order->setUpdatedAt(new \DateTime());

        $this->container->get('msi_store.order_manager')->update($order);

        return $this->getResponse();
    }

    private function getResponse($data = [])
    {
        $order = $this->container->get('msi_store.provider')->getOrder();

        if ($this->container->get('request')->isXmlHttpRequest()) {
            $redundant = [
                'count' => $order->getDetails()->count(),
                'flash' => '<strong>Succès</strong> : Le produit a été ajouté à <a href="'.$this->container->get('router')->generate('msi_store_order_show').'">votre panier</a> !',
            ];
            $data = array_merge($redundant, $data);

            return new JsonResponse($data);
        } else {
            return new RedirectResponse($this->container->get('router')->generate('msi_store_order_show'));
        }
    }
}
