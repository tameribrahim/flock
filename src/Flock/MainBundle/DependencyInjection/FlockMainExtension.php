<?php
/**
 * Created by amalraghav <amal.raghav@gmail.com>
 * Date: 30/08/11
 */

namespace Flock\MainBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class FlockMainExtension extends Extension
{
    function load(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('security.xml');
    }

    function getAlias()
    {
        return 'flock_main';
    }
}
