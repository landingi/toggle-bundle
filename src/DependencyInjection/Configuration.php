<?php
declare(strict_types=1);

namespace Landingi\ToggleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('landingi_toggle');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('dbal')
                    ->children()
                        ->scalarNode('connection_name')->end()
                    ->end()
                ->end()
                ->arrayNode('cache')
                    ->children()
                        ->booleanNode('enabled')->end()
                    ->end()
                    ->children()
                        ->arrayNode('redis_connection')
                            ->children()
                                ->scalarNode('schema')->end()
                            ->end()
                            ->children()
                                ->scalarNode('host')->end()
                            ->end()
                            ->children()
                                ->integerNode('port')->end()
                            ->end()
                        ->end()
                    ->end()
                    ->children()
                        ->integerNode('ttl')->isRequired()->end()
                    ->end()
            ->end();

        return $treeBuilder;
    }
}
