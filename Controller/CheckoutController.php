<?php

namespace Msi\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CheckoutController extends Controller
{
    // 1 address
    public function addressAction()
    {
        // faire un form pis mettre les infos du user sil est logger ou lui suggerer de logger
        $builder = $this->get('form.factory')->createBuilder();

        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('phone')
            ->add('ext')
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

        if ($this->getUser()) {
            $form->setData([
                'firstName' => $this->getUser()->getFirstName(),
                'lastName' => $this->getUser()->getLastName(),
                'phone' => $this->getUser()->getPhone(),
                'ext' => $this->getUser()->getExt(),
                'shippingCity' => $this->getUser()->getShippingCity(),
                'shippingAddress' => $this->getUser()->getShippingAddress(),
                'shippingAddress2' => $this->getUser()->getShippingAddress2(),
                'shippingProvince' => $this->getUser()->getShippingProvince(),
                'shippingCountry' => $this->getUser()->getShippingCountry(),
                'shippingZip' => $this->getUser()->getShippingZip(),
                'billingCity' => $this->getUser()->getBillingCity(),
                'billingAddress' => $this->getUser()->getBillingAddress(),
                'billingAddress2' => $this->getUser()->getBillingAddress2(),
                'billingProvince' => $this->getUser()->getBillingProvince(),
                'billingCountry' => $this->getUser()->getBillingCountry(),
                'billingZip' => $this->getUser()->getBillingZip(),
            ]);
        }

        return $this->render('MsiStoreBundle:Checkout:address.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // 2 payment
    public function paymentAction()
    {
        return $this->render('MsiStoreBundle:Checkout:payment.html.twig');
    }

    // 3 process
    public function processAction()
    {
        return $this->render('MsiStoreBundle:Checkout:payment.html.twig');
    }

    // 4 confirmation
    public function confirmationAction()
    {
        return $this->render('MsiStoreBundle:Checkout:payment.html.twig');
    }
}
