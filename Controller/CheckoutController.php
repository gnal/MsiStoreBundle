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

        $firstName = null;
        $lastName = null;
        $email = null;
        $phone = null;
        $ext = null;
        $shippingCity = null;
        $shippingAddress = null;
        $shippingAddress2 = null;
        $shippingProvince = null;
        $shippingCountry = null;
        $shippingZip = null;
        $billingCity = null;
        $billingAddress = null;
        $billingAddress2 = null;
        $billingProvince = null;
        $billingCountry = null;
        $billingZip = null;

        if ($this->getUser()) {
            $firstName = $this->getUser()->getFirstName();
            $lastName = $this->getUser()->getLastName();
            $email = $this->getUser()->getEmail();
            $phone = $this->getUser()->getPhone();
            $ext = $this->getUser()->getExt();
            $shippingCity = $this->getUser()->getShippingCity();
            $shippingAddress = $this->getUser()->getShippingAddress();
            $shippingAddress2 = $this->getUser()->getShippingAddress2();
            $shippingProvince = $this->getUser()->getShippingProvince();
            $shippingCountry = $this->getUser()->getShippingCountry();
            $shippingZip = $this->getUser()->getShippingZip();
            $billingCity = $this->getUser()->getBillingCity();
            $billingAddress = $this->getUser()->getBillingAddress();
            $billingAddress2 = $this->getUser()->getBillingAddress2();
            $billingProvince = $this->getUser()->getBillingProvince();
            $billingCountry = $this->getUser()->getBillingCountry();
            $billingZip = $this->getUser()->getBillingZip();
        }

        $order = $this->get('msi_store.provider')->getOrder();

        if ($order->getFirstName() !== null) $firstName = $order->getFirstName();
        if ($order->getLastName() !== null) $lastName = $order->getLastName();
        if ($order->getEmail() !== null) $email = $order->getEmail();
        if ($order->getPhone() !== null) $phone = $order->getPhone();
        if ($order->getExt() !== null) $ext = $order->getExt();
        if ($order->getShippingCity() !== null) $shippingCity = $order->getShippingCity();
        if ($order->getShippingAddress() !== null) $shippingAddress = $order->getShippingAddress();
        if ($order->getShippingAddress2() !== null) $shippingAddress2 = $order->getShippingAddress2();
        if ($order->getShippingProvince() !== null) $shippingProvince = $order->getShippingProvince();
        if ($order->getShippingCountry() !== null) $shippingCountry = $order->getShippingCountry();
        if ($order->getShippingZip() !== null) $shippingZip = $order->getShippingZip();
        if ($order->getBillingCity() !== null) $billingCity = $order->getBillingCity();
        if ($order->getBillingAddress() !== null) $billingAddress = $order->getBillingAddress();
        if ($order->getBillingAddress2() !== null) $billingAddress2 = $order->getBillingAddress2();
        if ($order->getBillingProvince() !== null) $billingProvince = $order->getBillingProvince();
        if ($order->getBillingCountry() !== null) $billingCountry = $order->getBillingCountry();
        if ($order->getBillingZip() !== null) $billingZip = $order->getBillingZip();

        $form->setData([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'ext' => $ext,
            'shippingCity' => $shippingCity,
            'shippingAddress' => $shippingAddress,
            'shippingAddress2' => $shippingAddress2,
            'shippingProvince' => $shippingProvince,
            'shippingCountry' => $shippingCountry,
            'shippingZip' => $shippingZip,
            'billingCity' => $billingCity,
            'billingAddress' => $billingAddress,
            'billingAddress2' => $billingAddress2,
            'billingProvince' => $billingProvince,
            'billingCountry' => $billingCountry,
            'billingZip' => $billingZip,
        ]);

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
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
