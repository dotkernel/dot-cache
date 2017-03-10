<?php
/**
 * @see https://github.com/dotkernel/dot-cache/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-cache/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\Cache\Factory;

use Interop\Container\ContainerInterface;

/**
 * Class StorageCacheAbstractServiceFactory
 * @package Dot\Cache\Factory
 */
class StorageCacheAbstractServiceFactory extends \Zend\Cache\Service\StorageCacheAbstractServiceFactory
{
    const PREFIX = 'dot-cache';

    /** @var string */
    protected $configKey = 'dot_cache';

    /** @var string */
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
     * @param string $requestedName
     * @param array|null $options
     * @return object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $parts = explode('.', $requestedName);
        return parent::__invoke($container, $parts[1], $options);
    }

    /**
     * @param ContainerInterface $container
     * @return array
     */
    protected function getConfig(ContainerInterface $container): array
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
