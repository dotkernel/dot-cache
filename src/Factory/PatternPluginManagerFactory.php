<?php
/**
 * @copyright: DotKernel
 * @library: dot-cache
 * @author: n3vra
 * Date: 1/22/2017
 * Time: 3:59 AM
 */

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
