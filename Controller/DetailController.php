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
            $detail->setQuantity($this->getRequest()->request->get('quantity'));
            $detail->setOrder($order);
            $order->getDetails()->add($detail);
        }

        $order->setUpdatedAt(new \DateTime());

        $this->container->get('msi_store.order_manager')->update($order);

        return $this->getResponse();
    }

    public function editAction()
    {
        $order = $this->container->get('msi_store.provider')->getOrder();

        foreach ($order->getDetails() as $row) {
            if ($row->getId() == $this->getRequest()->attributes->get('id')) {
                $detail = $row;
                break;
            }
        }

        $detail->setQuantity($this->getRequest()->request->get('quantity'));

        $this->container->get('msi_store.detail_manager')->update($detail);

        return $this->getResponse([
            'id' => $detail->getId(),
            'detailTotal' => number_format($this->container->get('msi_store.calculator')->getDetailTotal($detail), 2),
            'subtotal' => number_format($this->container->get('msi_store.calculator')->getOrderSubtotal($order), 2),
            'total' => number_format($this->container->get('msi_store.calculator')->getOrderTotal($order), 2),
            'gst' => number_format($this->container->get('msi_store.calculator')->getOrderGst($order), 2),
            'pst' => number_format($this->container->get('msi_store.calculator')->getOrderPst($order), 2),
        ]);
    }

    public function deleteAction()
    {
        $order = $this->container->get('msi_store.provider')->getOrder();

        foreach ($order->getDetails() as $row) {
            if ($row->getId() == $this->getRequest()->attributes->get('id')) {
                $detail = $row;
                break;
            }
        }

        $this->container->get('msi_store.detail_manager')->delete($detail);

        return $this->getResponse([
            'subtotal' => number_format($this->container->get('msi_store.calculator')->getOrderSubtotal($order), 2),
        ]);
    }

    private function getResponse($data = [])
    {
        $order = $this->container->get('msi_store.provider')->getOrder();

        if ($this->container->get('request')->isXmlHttpRequest()) {
            $redundant = [
                'count' => $order->count(),
                'flash' => '<strong>Succès</strong> : Le produit a été ajouté à <a href="'.$this->container->get('router')->generate('msi_store_order_show').'">votre panier</a> !',
            ];
            $data = array_merge($redundant, $data);

            return new JsonResponse($data);
        } else {
            return new RedirectResponse($this->container->get('router')->generate('msi_store_order_show'));
        }
    }
}
