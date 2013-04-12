<?php

namespace Msi\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

        $order->addDetail($product, $this->getRequest()->request->get('quantity'));

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
