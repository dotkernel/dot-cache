<?php
/**
 * @see https://github.com/dotkernel/dot-cache/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-cache/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\Cache\Factory;

use Psr\Container\ContainerInterface;
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
