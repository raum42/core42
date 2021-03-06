<?php

/*
 * core42
 *
 * @package core42
 * @link https://github.com/kiwi-suite/core42
 * @copyright Copyright (c) 2010 - 2017 kiwi suite (https://www.kiwi-suite.com)
 * @license MIT License
 * @author kiwi suite <dev@kiwi-suite.com>
 */

namespace Core42\Cache\Service;

use Psr\Cache\CacheItemPoolInterface;
use Zend\ServiceManager\AbstractPluginManager;

class CachePluginManager extends AbstractPluginManager
{
    /**
     * @var
     */
    protected $instanceOf = CacheItemPoolInterface::class;
}
