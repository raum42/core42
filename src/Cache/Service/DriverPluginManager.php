<?php
namespace Core42\Cache\Service;

use Core42\Cache\Driver\Service\ApcFactory;
use Core42\Cache\Driver\Service\BlackHoleFactory;
use Core42\Cache\Driver\Service\EphemeralFactory;
use Core42\Cache\Driver\Service\FileSystemFactory;
use Core42\Cache\Driver\Service\MemcacheFactory;
use Core42\Cache\Driver\Service\RedisFactory;
use Core42\Cache\Driver\Service\SqliteFactory;
use Stash\Driver\Apc;
use Stash\Driver\BlackHole;
use Stash\Driver\Ephemeral;
use Stash\Driver\FileSystem;
use Stash\Driver\Memcache;
use Stash\Driver\Redis;
use Stash\Driver\Sqlite;
use Stash\Interfaces\DriverInterface;
use Zend\ServiceManager\AbstractPluginManager;

class DriverPluginManager extends AbstractPluginManager
{
    /**
     * @var
     */
    protected $instanceOf = DriverInterface::class;

    /**
     * A list of factories (either as string name or callable)
     *
     * @var string[]|callable[]
     */
    protected $factories = [
        Apc::class              => ApcFactory::class,
        BlackHole::class        => BlackHoleFactory::class,
        Ephemeral::class        => EphemeralFactory::class,
        FileSystem::class       => FileSystemFactory::class,
        Memcache::class         => MemcacheFactory::class,
        Redis::class            => RedisFactory::class,
        Sqlite::class           => SqliteFactory::class,
    ];
}