<?php

namespace DependencyInjection\Collector;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class DatabaseStrategyConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('easy_backups');

        $rootNode
            ->children()
                ->arrayNode('strategies')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('identifier')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('description')
                                ->defaultValue('')
                            ->end()
                            ->scalarNode('dump_strategy')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->arrayNode('dump_settings')
                                ->children()
                                    ->scalarNode('type')
                                        ->isRequired()
                                        ->cannotBeEmpty()
                                    ->end()
                                    ->arrayNode('options')
                                        ->children()
                                            ->scalarNode('host')->isRequired()->end()
                                            ->scalarNode('user')->isRequired()->end()
                                            ->scalarNode('pass')->isRequired()->end()
                                            ->scalarNode('port')->defaultValue(3306)->end()
                                            ->scalarNode('name')->isRequired()->end()
                                            ->arrayNode('ignore_tables')
                                                ->prototype('scalar')
                                                ->end()
                                            ->end()
                                            ->booleanNode('one_dump_per_table')->defaultValue(false)->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->scalarNode('compressor_strategy')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('saver_strategy')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
