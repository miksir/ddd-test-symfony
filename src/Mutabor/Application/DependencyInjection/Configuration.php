<?php

namespace Mutabor\Application\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mutabor');

        // Here you should define the parameters that are allowed to
        // configure your bundle.

        return $treeBuilder;
    }
}
