<?php

/*
 * core42
 *
 * @package core42
 * @link https://github.com/raum42/core42
 * @copyright Copyright (c) 2010 - 2017 raum42 (https://raum42.at)
 * @license MIT License
 * @author raum42 <kiwi@raum42.at>
 */

namespace Core42;

use Core42\Asset\Hash\DefaultCommitHash;

return [
    'assets' => [
        'asset_url'         => null,
        'asset_path'        => null,
        'prepend_commit'    => false,
        'commit_strategy'   => DefaultCommitHash::class,
        'prepend_base_path' => true,
        'directories'       => [],
    ],
];
