<?php

use DigraphCMS\Cache\CacheableState;
use DigraphCMS\Cache\CachedInitializer;
use DigraphCMS\Config;
use DigraphCMS\DB\DB;
use DigraphCMS\Plugins\Plugins;

require_once __DIR__ . '/vendor/autoload.php';

// load plugins from composer
Plugins::loadFromComposer(__DIR__ . '/composer.lock');

// initialize config
CachedInitializer::run(
    'initialization',
    function (CacheableState $state) {
        $state->mergeConfig(Config::parseYamlFile(__DIR__ . '/config.yaml'), true);
        $state->mergeConfig(Config::parseYamlFile(__DIR__ . '/env.yaml'), true);
        $state->config('paths.base', __DIR__);
    },
    0
);

return
    [
        'paths' => [
            'migrations' => DB::migrationPaths(),
            'seeds' => array_merge(DB::seedPaths(), [__DIR__ . '/dev/seeds']),
        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_environment' => 'current',
            'current' => Config::get('db'),
        ],
        'version_order' => 'creation',
    ];
