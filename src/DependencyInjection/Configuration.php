<?php
namespace Dkplus\CsrfApiUnprotectionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /** @var string */
    private $treeRootName;

    /**
     * @param string $treeRootName
     */
    public function __construct($treeRootName)
    {
        $this->treeRootName = $treeRootName;
    }

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root($this->treeRootName)
            ->children()
            ->arrayNode('rules')
                ->addDefaultsIfNotSet()
                ->children()
                ->arrayNode('match_uri')
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($value) { return [$value]; })
                    ->end()
                    ->isRequired()
                    ->defaultValue(['#^(/app(_[a-zA-Z]*)?.php)?/api/#'])
                    ->prototype('scalar')->cannotBeEmpty()->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
