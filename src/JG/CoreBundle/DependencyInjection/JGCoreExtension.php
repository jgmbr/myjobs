<?php

namespace JG\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class JGCoreExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('jg_core.dir.csv', $config['dir']['csv']);
        $container->setParameter('jg_core.dir.zip', $config['dir']['zip']);
        $container->setParameter('jg_core.generation.zip', $config['generation']['zip']);
        $container->setParameter('jg_core.generation.delimiter', $config['generation']['delimiter']);
        $container->setParameter('jg_core.generation.extension.csv', $config['generation']['extension']['csv']);
        $container->setParameter('jg_core.generation.extension.zip', $config['generation']['extension']['zip']);
    }
}
