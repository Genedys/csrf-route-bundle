<?php

namespace Genedys\CsrfRouteBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Fabien Antoine <fabien@fantoine.fr>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('genedys_csrf_route');
        $rootNode = method_exists(TreeBuilder::class, 'getRootNode')
            ? $treeBuilder->getRootNode()
            : $treeBuilder->root('genedys_csrf_route');

        $rootNode
            ->children()
                ->booleanNode('enabled')->defaultTrue()->end()
                ->scalarNode('field_name')->defaultValue('_token')->end()
                ->scalarNode('token_provider_class')->defaultValue('Genedys\\CsrfRouteBundle\\Routing\\TokenProvider\\TokenProvider')->end()
                ->scalarNode('token_provider_base_class')->defaultValue('Genedys\\CsrfRouteBundle\\Routing\\TokenProvider\\AbstractTokenProvider')->end()
                ->scalarNode('token_provider_dumper_class')->defaultValue('Genedys\\CsrfRouteBundle\\Routing\\TokenProvider\\Dumper\\TokenProviderDumper')->end()
                ->scalarNode('token_provider_cache_class')->defaultValue('%router.cache_class_prefix%CsrfTokenProvider')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
