<?php

namespace Genedys\CsrfRouteBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Fabien Antoine <fabien@fantoine.fr>
 */
class SetRouterPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        // Replace default router
        if ($container->hasAlias('router')) {
            // Set parent router
            $container
                ->findDefinition('genedys_csrf_route.routing.router')
                ->addArgument(new Reference((string) $container->getAlias('router')));
            ;

            // Update alias
            $container->setAlias('router', 'genedys_csrf_route.routing.router');
            $alias = $container->getAlias('router');
            if (method_exists($alias, 'setPrivate')) {
                $alias->setPrivate(false);
            }
        }

        // Replace Sensio Route annotation loader
        $container
            ->findDefinition('sensio_framework_extra.routing.loader.annot_class')
            ->setClass('%genedys_csrf_route.routing.loader.class%')
        ;
    }
}
