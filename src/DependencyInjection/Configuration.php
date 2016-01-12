<?php

namespace Deadkash\MenuBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('deadkashmenubundle');

        $rootNode
            ->children()
                ->scalarNode('source')->isRequired()->cannotBeEmpty()->end()
                ->arrayNode('templates')
                    ->useAttributeAsKey('key')
                    ->prototype('scalar')->end()
                ->end()
        ;

        return $treeBuilder;
    }
}