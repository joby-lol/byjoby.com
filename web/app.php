<?php
require __DIR__ . "/../vendor/autoload.php";

//initialize a PlasterApplication, passing it a
//list of config files to use
$config = array(__DIR__ . '/../plaster.yaml');
$app    = new jobyone\Plaster\PlasterApplication($config);

//render with no arguments to use $_SERVER['PATH_INFO']
//as the url
$app->render();
