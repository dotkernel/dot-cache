<?php

declare(strict_types=1);

namespace Dot\Cache\Exception;

use InvalidArgumentException;
use Symfony\Component\Cache\Marshaller\MarshallerInterface;

use function get_debug_type;
use function sprintf;

final class InvalidConfigException extends InvalidArgumentException
{
    public static function notAnArray(string $key, mixed $value): self
    {
        return new self(sprintf('Config key "%s" must be an array, %s given.', $key, get_debug_type($value)));
    }

    public static function missingDirectory(string $key): self
    {
        return new self(sprintf(
            'Config key "%s" is required and must be a non-empty string: the path where cache files are stored.',
            $key
        ));
    }

    public static function notAString(string $key, mixed $value): self
    {
        return new self(sprintf('Config key "%s" must be a string, %s given.', $key, get_debug_type($value)));
    }

    public static function invalidLifetime(string $key, mixed $value): self
    {
        return new self(sprintf(
            'Config key "%s" must be a non-negative integer number of seconds, %s given.',
            $key,
            get_debug_type($value)
        ));
    }

    public static function invalidMarshaller(string $key, mixed $value): self
    {
        return new self(sprintf(
            'Config key "%s" must be a service name or an instance of %s, %s given.',
            $key,
            MarshallerInterface::class,
            get_debug_type($value)
        ));
    }
}
