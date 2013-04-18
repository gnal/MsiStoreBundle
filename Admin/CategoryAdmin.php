<?php

namespace Msi\StoreBundle\Admin;

use Msi\CmfBundle\Admin\Admin;
use Msi\CmfBundle\Grid\GridBuilder;
use Symfony\Component\Form\FormBuilder;

class CategoryAdmin extends Admin
{
    public function configure()
    {
        $this->options = [
            'search_fields' => ['t.name'],
            'order_by' => [
                'a.root' => 'ASC',
                'a.lft' => 'ASC',
            ],
        ];
    }

    public function buildGrid(GridBuilder $builder)
    {
        $builder
            ->add('published', 'boolean')
            ->add('name', 'tree')
            ->add('', 'action')
        ;
    }

    public function buildForm(FormBuilder $builder)
    {
        $builder
            ->add('parent')
        ;
    }

    public function buildTranslationForm(FormBuilder $builder)
    {
        $builder
            ->add('name')
        ;
    }
}
