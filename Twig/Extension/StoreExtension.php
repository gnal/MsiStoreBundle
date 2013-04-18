<?php

namespace Msi\StoreBundle\Twig\Extension;

class StoreExtension extends \Twig_Extension
{
    private $environment;

    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getName()
    {
        return 'msi_store';
    }

    public function getGlobals()
    {
        $globals = [];

        if (!$this->container->isScopeActive('request')) {
            return $globals;
        }

        $globals['order'] = $this->container->get('msi_store.provider')->getOrder();

        return $globals;
    }
}
