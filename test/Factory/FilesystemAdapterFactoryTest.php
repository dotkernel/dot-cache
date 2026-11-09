<?php

declare(strict_types=1);

namespace DotTest\Cache\Factory;

use Dot\Cache\Adapter\FilesystemAdapter;
use Dot\Cache\Exception\InvalidConfigException;
use Dot\Cache\Factory\FilesystemAdapterFactory;
use DotTest\Cache\Fixture\ArrayContainer;
use DotTest\Cache\Fixture\TemporaryDirectory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionProperty;
use stdClass;
use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter as SymfonyFilesystemAdapter;
use Symfony\Component\Cache\Marshaller\DefaultMarshaller;
use Symfony\Component\Cache\Marshaller\MarshallerInterface;

class FilesystemAdapterFactoryTest extends TestCase
{
    private TemporaryDirectory $directory;

    protected function setUp(): void
    {
        $this->directory = new TemporaryDirectory();
    }

    protected function tearDown(): void
    {
        $this->directory->remove();
    }

    public function testCreatesWorkingAdapterFromConfig(): void
    {
        $adapter = $this->create([
            'namespace'        => 'doctrine',
            'directory'        => $this->directory->path,
            'default_lifetime' => 60,
        ]);
        $adapter->save($adapter->getItem('key')->set('value'));

        $this->assertSame(60, $this->defaultLifetime($adapter));
        $this->assertDirectoryExists($this->directory->path . '/doctrine');
        $this->assertSame('value', $adapter->getItem('key')->get());
    }

    public function testDefaultLifetimeDefaultsToZero(): void
    {
        $adapter = $this->create(['directory' => $this->directory->path]);

        $this->assertSame(0, $this->defaultLifetime($adapter));
    }

    public function testReadsDeprecatedDefaultLifeTimeKey(): void
    {
        $adapter = $this->create(['directory' => $this->directory->path, 'default_life_time' => 30]);

        $this->assertSame(30, $this->defaultLifetime($adapter));
    }

    public function testDefaultLifetimeWinsOverDeprecatedKey(): void
    {
        $adapter = $this->create([
            'directory'         => $this->directory->path,
            'default_lifetime'  => 60,
            'default_life_time' => 30,
        ]);

        $this->assertSame(60, $this->defaultLifetime($adapter));
    }

    public function testAcceptsNumericStringLifetime(): void
    {
        $adapter = $this->create(['directory' => $this->directory->path, 'default_lifetime' => '3600']);

        $this->assertSame(3600, $this->defaultLifetime($adapter));
    }

    /**
     * @return iterable<string, array{mixed}>
     */
    public static function invalidLifetimeProvider(): iterable
    {
        yield 'negative'    => [-1];
        yield 'non-numeric' => ['an hour'];
        yield 'float'       => [1.5];
        yield 'array'       => [[60]];
    }

    #[DataProvider('invalidLifetimeProvider')]
    public function testRejectsInvalidLifetime(mixed $lifetime): void
    {
        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage('doctrine.cache.filesystem.default_lifetime');

        $this->create(['directory' => $this->directory->path, 'default_lifetime' => $lifetime]);
    }

    public function testResolvesMarshallerServiceName(): void
    {
        $marshaller = new DefaultMarshaller();
        $config     = ['directory' => $this->directory->path, 'marshaller' => 'my.marshaller'];

        $adapter = (new FilesystemAdapterFactory())(
            new ArrayContainer(['config' => $this->appConfig($config), 'my.marshaller' => $marshaller])
        );

        $this->assertSame($marshaller, $this->marshaller($adapter));
    }

    public function testUsesMarshallerInstance(): void
    {
        $marshaller = new DefaultMarshaller();

        $adapter = $this->create(['directory' => $this->directory->path, 'marshaller' => $marshaller]);

        $this->assertSame($marshaller, $this->marshaller($adapter));
    }

    public function testRejectsMarshallerOfWrongType(): void
    {
        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage('doctrine.cache.filesystem.marshaller');

        $this->create(['directory' => $this->directory->path, 'marshaller' => new stdClass()]);
    }

    public function testMissingMarshallerServiceIsReported(): void
    {
        $this->expectException(NotFoundExceptionInterface::class);

        $this->create(['directory' => $this->directory->path, 'marshaller' => 'missing.marshaller']);
    }

    public function testRejectsMissingDirectory(): void
    {
        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage('doctrine.cache.filesystem.directory');

        $this->create(['namespace' => 'doctrine']);
    }

    public function testRejectsEmptyDirectory(): void
    {
        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage('doctrine.cache.filesystem.directory');

        $this->create(['directory' => '']);
    }

    public function testRejectsNonStringNamespace(): void
    {
        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage('doctrine.cache.filesystem.namespace');

        $this->create(['directory' => $this->directory->path, 'namespace' => 42]);
    }

    public function testRejectsMissingFilesystemEntry(): void
    {
        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage('doctrine.cache.filesystem.directory');

        (new FilesystemAdapterFactory())(
            new ArrayContainer(['config' => ['doctrine' => ['cache' => ['file' => ['directory' => '/tmp']]]]])
        );
    }

    public function testRejectsMissingConfigService(): void
    {
        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage('doctrine.cache.filesystem.directory');

        (new FilesystemAdapterFactory())(new ArrayContainer());
    }

    public function testRejectsFilesystemEntryThatIsNotAnArray(): void
    {
        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage('doctrine.cache.filesystem');

        (new FilesystemAdapterFactory())(
            new ArrayContainer(['config' => ['doctrine' => ['cache' => ['filesystem' => 'data/cache']]]])
        );
    }

    /**
     * @param array<string, mixed> $filesystemConfig
     */
    private function create(array $filesystemConfig): FilesystemAdapter
    {
        return (new FilesystemAdapterFactory())(
            new ArrayContainer(['config' => $this->appConfig($filesystemConfig)])
        );
    }

    /**
     * @param array<string, mixed> $filesystemConfig
     * @return array{doctrine: array{cache: array{filesystem: array<string, mixed>}}}
     */
    private function appConfig(array $filesystemConfig): array
    {
        return ['doctrine' => ['cache' => ['filesystem' => $filesystemConfig]]];
    }

    private function defaultLifetime(FilesystemAdapter $adapter): mixed
    {
        return (new ReflectionProperty(AbstractAdapter::class, 'defaultLifetime'))->getValue($adapter);
    }

    private function marshaller(FilesystemAdapter $adapter): mixed
    {
        $value = (new ReflectionProperty(SymfonyFilesystemAdapter::class, 'marshaller'))->getValue($adapter);
        $this->assertInstanceOf(MarshallerInterface::class, $value);

        return $value;
    }
}
