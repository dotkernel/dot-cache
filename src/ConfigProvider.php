<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-cache
 * @author: n3vrax
 * Date: 1/22/2017
 * Time: 3:09 AM
 */

declare(strict_types=1);

namespace Dot\Cache;

use Dot\Cache\Factory\PatternPluginManagerFactory;
use Dot\Cache\Factory\StorageAdapterPluginManagerFactory;
use Dot\Cache\Factory\StorageCacheAbstractServiceFactory;
use Dot\Cache\Factory\StoragePluginManagerFactory;
use Zend\Cache\PatternPluginManager;
use Zend\Cache\Storage\AdapterPluginManager;
use Zend\Cache\Storage\PluginManager;

/**
 * Class ConfigProvider
 * @package Dot\Cache
 */
class ConfigProvider
{
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependenciesConfig(),

            'dot_cache' => [

                'caches' => [],

                'pattern_manager' => [],

                'plugin_manager' => [],

                'adapter_manager' => [],
            ],
        ];
    }

    public function getDependenciesConfig() : array
    {
        return [
            'abstract_factories' => [
                StorageCacheAbstractServiceFactory::class,
            ],
            'factories' => [
                PatternPluginManager::class => PatternPluginManagerFactory::class,
                AdapterPluginManager::class => StorageAdapterPluginManagerFactory::class,
                PluginManager::class => StoragePluginManagerFactory::class,
            ],
        ];
    }
}
