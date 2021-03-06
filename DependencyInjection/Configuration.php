<?php

namespace Msi\StoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('msi_store');

        $rootNode
            ->children()
                ->scalarNode('calculator_class')->defaultValue('Msi\StoreBundle\Calculator\Calculator')->cannotBeEmpty()->end()
            ->end()
        ;

        $this->addProductSection($rootNode);
        $this->addOrderSection($rootNode);
        $this->addDetailSection($rootNode);
        $this->addCategorySection($rootNode);

        return $treeBuilder;
    }

    private function addProductSection($node)
    {
        $node
            ->children()
                ->scalarNode('product_class')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('product_admin')->defaultValue('Msi\StoreBundle\Admin\ProductAdmin')->cannotBeEmpty()->end()
                ->scalarNode('product_manager')->defaultValue('Msi\StoreBundle\Doctrine\ProductManager')->cannotBeEmpty()->end()
            ->end()
        ;
    }

    private function addOrderSection($node)
    {
        $node
            ->children()
                ->scalarNode('order_class')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('order_admin')->defaultValue('Msi\StoreBundle\Admin\OrderAdmin')->cannotBeEmpty()->end()
            ->end()
        ;
    }

    private function addDetailSection($node)
    {
        $node
            ->children()
                ->scalarNode('detail_class')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('detail_admin')->defaultValue('Msi\StoreBundle\Admin\DetailAdmin')->cannotBeEmpty()->end()
            ->end()
        ;
    }

    private function addCategorySection($node)
    {
        $node
            ->children()
                ->scalarNode('category_class')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('category_admin')->defaultValue('Msi\StoreBundle\Admin\CategoryAdmin')->cannotBeEmpty()->end()
            ->end()
        ;
    }
}
