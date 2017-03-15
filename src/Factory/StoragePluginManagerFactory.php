<?php
/**
 * @see https://github.com/dotkernel/dot-cache/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-cache/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\Cache\Factory;

use Psr\Container\ContainerInterface;
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
