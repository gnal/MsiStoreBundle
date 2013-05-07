<?php

namespace Msi\StoreBundle\Admin;

use Msi\CmfBundle\Admin\Admin;
use Msi\CmfBundle\Grid\GridBuilder;
use Symfony\Component\Form\FormBuilder;

class OrderAdmin extends Admin
{
    public function buildGrid(GridBuilder $builder)
    {
        $builder
            ->add('id')
            ->add('frozenAt', 'date')
            ->add('', 'action')
        ;
    }

    public function buildForm(FormBuilder $builder)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('phone')
            ->add('ext')
            ->add('shipping')
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
    }
}
