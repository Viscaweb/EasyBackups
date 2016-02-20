<?php

namespace DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class SaverCompilerPass
 */
class SaverCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        if (!$container->has('chain.saver')){
            return;
        }

        $chain = $container->findDefinition('chain.saver');

        $taggedSavers = $container->findTaggedServiceIds('saver');
        foreach($taggedSavers as $serviceId => $tags){
            $serviceAlias = $tags[0]['alias'];
            $chain->addMethodCall(
                'addSaver',
                [$serviceAlias, new Reference($serviceId)]
            );
        }
    }

}
