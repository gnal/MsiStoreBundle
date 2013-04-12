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

        $this->addProductSection($rootNode);
        $this->addOrderSection($rootNode);
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
