<?php
/**
 * @copyright: DotKernel
 * @library: dot-cache
 * @author: n3vra
 * Date: 1/22/2017
 * Time: 4:00 AM
 */

declare(strict_types=1);

namespace Dot\Cache\Factory;

use Interop\Container\ContainerInterface;
use Zend\Cache\Storage\AdapterPluginManager;

/**
 * Class StorageAdapterPluginManagerFactory
 * @package Dot\Cache\Factory
 */
class StorageAdapterPluginManagerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AdapterPluginManager($container, $container->get('config')['dot_cache']['adapter_manager']);
    }
}
