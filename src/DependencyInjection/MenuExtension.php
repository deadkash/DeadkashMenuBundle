<?php

namespace MenuBundle\DependencyInjection;


use MenuBundle\DependencyInjection\Configuration;
use MenuBundle\Service\BuildService;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MenuExtension extends Extension
{
    /**
     * @return string
     */
    public function getAlias()
    {
        return 'menubundle';
    }

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $processedConfig = $this->processConfiguration($configuration, $configs);

        $container->setParameter(BuildService::MENUBUNDLE_SOURCE, $processedConfig['source']);

        if (isset($processedConfig['templates'])) {
            $container->setParameter(BuildService::MENUBUNDLE_TEMPLATES, $processedConfig['templates']);
        }
    }
}