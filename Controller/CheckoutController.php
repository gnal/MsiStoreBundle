<?php

namespace Msi\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CheckoutController extends Controller
{
    public function addressAction()
    {
        $builder = $this->get('form.factory')->createBuilder();

        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email', 'email')
            ->add('phone')
            ->add('ext', 'text', [
                'attr' => [
                    'style' => 'width: 60px;',
                ],
            ])
            ->add('shippingCity')
            ->add('shippingAddress')
            ->add('shippingAddress2')
            ->add('shippingProvince')
            ->add('shippingCountry')
            ->add('shippingZip')
            ->add('billingCity')
            ->add('billingAddress')
            ->add('billingAddress2')
            ->add('billingProvince')
            ->add('billingCountry')
            ->add('billingZip')
        ;

        $form = $builder->getForm();

        $form->setData([
            'firstName' => $order->getFirstName() ?: $this->getUser() ? $this->getUser()->getFirstName() : null,
            'lastName' => $order->getLastName() ?: $this->getUser() ? $this->getUser()->getLastName() : null,
            'email' => $order->getEmail() ?: $this->getUser() ? $this->getUser()->getEmail() : null,
            'phone' => $order->getPhone() ?: $this->getUser() ? $this->getUser()->getPhone() : null,
            'ext' => $order->getExt() ?: $this->getUser() ? $this->getUser()->getExt() : null,
            'shippingCity' => $order->getShippingCity() ?: $this->getUser() ? $this->getUser()->getShippingCity() : null,
            'shippingAddress' => $order->getShippingAddress() ?: $this->getUser() ? $this->getUser()->getShippingAddress() : null,
            'shippingAddress2' => $order->getShippingAddress2() ?: $this->getUser() ? $this->getUser()->getShippingAddress2() : null,
            'shippingProvince' => $order->getShippingProvince() ?: $this->getUser() ? $this->getUser()->getShippingProvince() : null,
            'shippingCountry' => $order->getShippingCountry() ?: $this->getUser() ? $this->getUser()->getShippingCountry() : null,
            'shippingZip' => $order->getShippingZip() ?: $this->getUser() ? $this->getUser()->getShippingZip() : null,
            'billingCity' => $order->getBillingCity() ?: $this->getUser() ? $this->getUser()->getBillingCity() : null,
            'billingAddress' => $order->getBillingAddress() ?: $this->getUser() ? $this->getUser()->getBillingAddress() : null,
            'billingAddress2' => $order->getBillingAddress2() ?: $this->getUser() ? $this->getUser()->getBillingAddress2() : null,
            'billingProvince' => $order->getBillingProvince() ?: $this->getUser() ? $this->getUser()->getBillingProvince() : null,
            'billingCountry' => $order->getBillingCountry() ?: $this->getUser() ? $this->getUser()->getBillingCountry() : null,
            'billingZip' => $order->getBillingZip() ?: $this->getUser() ? $this->getUser()->getBillingZip() : null,
        ]);

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $order = $this->get('msi_store.provider')->getOrder();
                $order
                    ->setFirstName($form->getData()['firstName'])
                    ->setLastName($form->getData()['lastName'])
                    ->setEmail($form->getData()['email'])
                    ->setPhone($form->getData()['phone'])
                    ->setExt($form->getData()['ext'])
                    ->setShippingCity($form->getData()['shippingCity'])
                    ->setShippingAddress($form->getData()['shippingAddress'])
                    ->setShippingAddress2($form->getData()['shippingAddress2'])
                    ->setShippingProvince($form->getData()['shippingProvince'])
                    ->setShippingCountry($form->getData()['shippingCountry'])
                    ->setShippingZip($form->getData()['shippingZip'])
                    ->setBillingCity($form->getData()['billingCity'])
                    ->setBillingAddress($form->getData()['billingAddress'])
                    ->setBillingAddress2($form->getData()['billingAddress2'])
                    ->setBillingProvince($form->getData()['billingProvince'])
                    ->setBillingCountry($form->getData()['billingCountry'])
                    ->setBillingZip($form->getData()['billingZip'])
                ;
                $this->container->get('msi_store.order_manager')->update($order);

                return $this->redirect($this->generateUrl('msi_store_checkout_review'));
            }
        }

        return $this->render('MsiStoreBundle:Checkout:address.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function reviewAction()
    {
        return $this->render('MsiStoreBundle:Checkout:review.html.twig', [
            'calculator' => $this->get('msi_store.calculator'),
        ]);
    }

    public function paymentAction()
    {
        // todo: payment

        // if ($this->getRequest()->isMethod('POST')) {
        //     $form->bind($this->getRequest());
        //     if ($form->isValid()) {
        //         $this->freezeOrder();

        //         return $this->redirect($this->generateUrl('msi_store_checkout_confirmation'));
        //     }
        // }

        if ($this->getRequest()->isMethod('POST')) {
            $this->freezeOrder();

            return $this->redirect($this->generateUrl('msi_store_checkout_confirmation'));
        }

        return $this->render('MsiStoreBundle:Checkout:payment.html.twig');
    }

    public function confirmationAction()
    {
        return $this->render('MsiStoreBundle:Checkout:confirmation.html.twig');
    }

    private function freezeOrder()
    {
        $order = $this->get('msi_store.provider')->getOrder();
        $order
            ->setFrozenAt(new \DateTime())
            ->setIp($this->getRequest()->getClientIp())
            ->setShipping($this->get('msi_store.calculator')->getShipping())
            ->setPst($this->get('msi_store.calculator')->getPst())
            ->setGst($this->get('msi_store.calculator')->getGst())
        ;

        foreach ($order->getDetails() as $detail) {
            $product = $detail->getProduct();
            $detail
                ->setName($product->getTranslation()->getName())
                ->setPrice($product->getPrice())
                ->setTaxable($product->getTaxable())
                ->setTotal($this->get('msi_store.calculator')->getDetailTotal($detail))
            ;
        }

        $this->container->get('msi_store.order_manager')->update($order);
    }
}
