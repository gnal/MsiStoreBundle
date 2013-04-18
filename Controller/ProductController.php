<?php

namespace Msi\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function indexAction()
    {
        $qb = $this->get('msi_store.product_manager')->getFindProductsQueryBuilder();

        if ($this->getRequest()->query->get('c')) {
            $category = $this->container->get('msi_store.category_manager')->getOneBy(
                [
                    'a.id' => $this->getRequest()->query->get('c'),
                    'a.published' => true,
                ]
            );

            $parameters['category'] = $category;

            $qb->andWhere('c.root = :root')->setParameter('root', $category->getRoot());
            $qb->andWhere('c.lft >= :lft')->setParameter('lft', $category->getLft());
            $qb->andWhere('c.rgt <= :rgt')->setParameter('rgt', $category->getRgt());
        }

        $products = $qb->getQuery()->execute();
        $parameters['products'] = $products;

        $categories = $this->container->get('msi_store.category_manager')->getFindByQueryBuilder(
            [
                'a.published' => true,
                'a.lvl' => '0',
            ],
            [
                'a.translations' => 't',
            ],
            ['t.name' => 'ASC']
        )->getQuery()->execute();

        $parameters['categories'] = $categories;

        return $this->render('MsiStoreBundle:Product:index.html.twig', $parameters);
    }

    public function showAction()
    {
        $product = $this->container->get('msi_store.product_manager')->getOneBy([
            'a.id' => $this->getRequest()->attributes->get('id'),
            'a.published' => true,
        ]);

        return $this->render('MsiStoreBundle:Product:show.html.twig', ['product' => $product]);
    }
}
