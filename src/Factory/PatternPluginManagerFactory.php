<?php
/**
 * @see https://github.com/dotkernel/dot-cache/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-cache/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\Cache\Factory;

use Interop\Container\ContainerInterface;
use Zend\Cache\PatternPluginManager;

/**
 * Class PatternPluginManagerFactory
 * @package Dot\Cache\Factory
 */
class PatternPluginManagerFactory
{
    public function __invoke(ContainerInterface $container, $requestedName)
    {
        return new PatternPluginManager($container, $container->get('config')['dot_cache']['pattern_manager']);
    }
}
