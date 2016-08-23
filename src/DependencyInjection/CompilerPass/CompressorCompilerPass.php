<?php

namespace DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CompressorCompilerPass.
 */
class CompressorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('chain.compressor')) {
            return;
        }

        $chain = $container->findDefinition('chain.compressor');

        $taggedCompressors = $container->findTaggedServiceIds('compressor');
        foreach ($taggedCompressors as $serviceId => $tags) {
            $serviceAlias = $tags[0]['alias'];
            $chain->addMethodCall(
                'addCompressor',
                [$serviceAlias, new Reference($serviceId)]
            );
        }
    }
}
