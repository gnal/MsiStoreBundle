<?php

namespace Msi\StoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MsiStoreExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('admin.yml');

        $this->registerConfiguration($config, $container);
    }

    private function registerConfiguration($config, ContainerBuilder $container)
    {
        $container->setParameter('msi_store.product.class', $config['product_class']);
        $container->setParameter('msi_store.order.class', $config['order_class']);
        $container->setParameter('msi_store.category.class', $config['category_class']);
        $container->setParameter('msi_store.detail.class', $config['detail_class']);

        $container->setParameter('msi_store.product.admin', $config['product_admin']);
        $container->setParameter('msi_store.order.admin', $config['order_admin']);
        $container->setParameter('msi_store.category.admin', $config['category_admin']);
        $container->setParameter('msi_store.detail.admin', $config['detail_admin']);

        $container->setParameter('msi_store.product.manager', $config['product_manager']);

        $container->setParameter('msi_store.calculator', $config['calculator_class']);
    }
}
