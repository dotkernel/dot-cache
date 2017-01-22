<?php
/**
 * @copyright: DotKernel
 * @library: dot-cache
 * @author: n3vra
 * Date: 1/22/2017
 * Time: 3:20 AM
 */

namespace Dot\Cache\Factory;

use Interop\Container\ContainerInterface;

/**
 * Class StorageCacheAbstractServiceFactory
 * @package Dot\Cache\Factory
 */
class StorageCacheAbstractServiceFactory extends \Zend\Cache\Service\StorageCacheAbstractServiceFactory
{
    const PREFIX = 'dot-cache';

    /** @var string  */
    protected $configKey = 'dot_cache';

    /** @var string  */
    protected $subConfigKey = 'caches';

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $parts = explode('.', $requestedName);
        if (count($parts) !== 2) {
            return false;
        }
        if ($parts[0] !== static::PREFIX) {
            return false;
        }

        return parent::canCreate($container, $parts[1]);
    }

    /**
     * @param ContainerInterface $container
     * @return array
     */
    protected function getConfig(ContainerInterface $container)
    {
        parent::getConfig($container);

        if (!empty($this->config)
            && isset($this->config[$this->subConfigKey])
            && is_array($this->config[$this->subConfigKey])
        ) {
            $this->config = $this->config[$this->subConfigKey];
        }

        return $this->config;
    }
}
