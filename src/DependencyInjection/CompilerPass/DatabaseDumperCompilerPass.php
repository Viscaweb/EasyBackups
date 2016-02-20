<?php

namespace DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class DatabaseDumperCompilerPass
 */
class DatabaseDumperCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        if (!$container->has('chain.dumper.database')) {
            return;
        }

        $chain = $container->findDefinition('chain.dumper.database');

        $taggedDatabasesDumper = $container->findTaggedServiceIds('dumper.database');
        foreach ($taggedDatabasesDumper as $serviceId => $tags) {
            $serviceAlias = $tags[0]['alias'];
            $chain->addMethodCall(
                'addDumper',
                [$serviceAlias, new Reference($serviceId)]
            );
        }
    }

}
