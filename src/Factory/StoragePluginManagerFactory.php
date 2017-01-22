<?php
/**
 * @copyright: DotKernel
 * @library: dot-cache
 * @author: n3vra
 * Date: 1/22/2017
 * Time: 4:00 AM
 */

namespace Dot\Cache\Factory;

use Interop\Container\ContainerInterface;
use Zend\Cache\Storage\PluginManager;

/**
 * Class StoragePluginManagerFactory
 * @package Dot\Cache\Factory
 */
class StoragePluginManagerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new PluginManager($container, $container->get('config')['dot_cache']['plugin_manager']);
    }
}
