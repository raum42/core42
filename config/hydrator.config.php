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

namespace Core42;

use Core42\Hydrator\BaseHydrator;
use Core42\Hydrator\Service\BaseHydratorFactory;
use Core42\Hydrator\Strategy\ArrayStrategy;
use Core42\Hydrator\Strategy\BooleanStrategy;
use Core42\Hydrator\Strategy\BooleanTinyintStrategy;
use Core42\Hydrator\Strategy\DateStrategy;
use Core42\Hydrator\Strategy\DateTimeStrategy;
use Core42\Hydrator\Strategy\DateTimeTimestampStrategy;
use Core42\Hydrator\Strategy\FloatStrategy;
use Core42\Hydrator\Strategy\IntegerStrategy;
use Core42\Hydrator\Strategy\JsonStrategy;
use Core42\Hydrator\Strategy\StringStrategy;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'hydrator_strategies' => [
        'factories' => [
            BooleanStrategy::class              => InvokableFactory::class,
            BooleanTinyintStrategy::class       => InvokableFactory::class,
            DateStrategy::class                 => InvokableFactory::class,
            DateTimeStrategy::class             => InvokableFactory::class,
            DateTimeTimestampStrategy::class    => InvokableFactory::class,
            FloatStrategy::class                => InvokableFactory::class,
            IntegerStrategy::class              => InvokableFactory::class,
            StringStrategy::class               => InvokableFactory::class,
            JsonStrategy::class                 => InvokableFactory::class,
            ArrayStrategy::class                => InvokableFactory::class,
        ],
        'aliases' => [
            'boolean'                           => BooleanStrategy::class,
            'booleanTinyint'                    => BooleanTinyintStrategy::class,
            'date'                              => DateStrategy::class,
            'dateTime'                          => DateTimeStrategy::class,
            'dateTimeTimestamp'                 => DateTimeTimestampStrategy::class,
            'float'                             => FloatStrategy::class,
            'integer'                           => IntegerStrategy::class,
            'string'                            => StringStrategy::class,
            'json'                              => JsonStrategy::class,
            'array'                             => ArrayStrategy::class,
        ],
    ],

    'hydrators' => [
        'factories' => [
            BaseHydrator::class                 => BaseHydratorFactory::class,
        ],
    ],
];
