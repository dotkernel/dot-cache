<?php
/**
 * @see https://github.com/dotkernel/dot-cache/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-cache/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\Cache;

use Dot\Cache\Factory\PatternPluginManagerFactory;
use Dot\Cache\Factory\StorageAdapterPluginManagerFactory;
use Dot\Cache\Factory\StorageCacheAbstractServiceFactory;
use Dot\Cache\Factory\StoragePluginManagerFactory;
use Laminas\Cache\PatternPluginManager;
use Laminas\Cache\Storage\AdapterPluginManager;
use Laminas\Cache\Storage\PluginManager;

/**
 * Class ConfigProvider
 * @package Dot\Cache
 */
class ConfigProvider
{
    public function __invoke(): array
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

    public function getDependenciesConfig(): array
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
