<?php

use DigraphCMS\Cache\CacheableState;
use DigraphCMS\Cache\CachedInitializer;
use DigraphCMS\Config;
use DigraphCMS\Digraph;
use DigraphCMS\Plugins\Plugins;

// load autoloader after cli server check
require_once __DIR__ . "/../vendor/autoload.php";

// special case for running in PHP's built-in server
// if you won't be using this, you can safely comment it out
// this will save a negligible, but non-zero amount of time
if (php_sapi_name() === 'cli-server') {
    $r = @reset(explode('?', $_SERVER['REQUEST_URI'], 2));
    if ($r == '/favicon.ico' || substr($r, 0, 7) == '/files/') {
        return false;
    }
}

// otherwise we configure the initialization cache with an
// infinite lifetime, as config shouldn't change once
// a version of the site is deployed
else {
    CachedInitializer::configureCache(__DIR__ . '/../cache', -1);
}

// load plugins from composer
Plugins::loadFromComposer(__DIR__ . '/../composer.lock');

// initialize config
CachedInitializer::run(
    'initialization',
    function (CacheableState $state) {
        $state->mergeConfig(Config::parseYamlFile(__DIR__ . '/../digraph.yaml'), true);
        $state->mergeConfig(Config::parseYamlFile(__DIR__ . '/../digraph-env.yaml'), true);
        $state->config('paths.base', __DIR__ . '/..');
    }
);

// build and render response
Digraph::renderActualRequest();
