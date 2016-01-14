<?php

use CoreBundle\SilexBootstrapper;
use Symfony\Component\Yaml\Parser;
use Silex\Application;
use Symfony\Component\Debug\ExceptionHandler;

require_once __DIR__ . '/vendor/autoload.php';

ExceptionHandler::register();

$app = new Application();
$app['appDir'] = __DIR__;
$bootstrapper = new SilexBootstrapper($app);

//yaml provider must be set up first, to load config
$yaml = new Parser();
$app['yaml'] = $app->protect(function($value) use ($app, $yaml) {
	return $yaml->parse($value);
});

//load config and boot
$config = $app['yaml'](file_get_contents(__DIR__ . '/config/config.yaml'));
if (file_exists(__DIR__ . '/config/environment.yaml')) {
	$config_env = $app['yaml'](file_get_contents(__DIR__ . '/config/environment.yaml'));
	$config = array_replace_recursive($config, $config_env);
}
//set timezone explicitly before booting
date_default_timezone_set($config['config']['timezone']);
//load config and boot
$bootstrapper->loadConfig($config, '');
$bootstrapper->boot();

//passthrough handler
call_user_func(function() use($app) {
	$pt = new \CoreBundle\PassthroughBuilder($app);
	$url = $_SERVER['REDIRECT_URL'];
	$render = $pt->render($url);
	if ($render) {
		$app->match($url, function() use($render) {
			return $render;
		});
	}
});

//content handler
call_user_func(function() use($app) {
	$cb = new \CoreBundle\ContentBuilder($app);
	$url = $_SERVER['REDIRECT_URL'];
	$render = $cb->render($url);
	if ($render) {
		$app->match($url, function() use($render) {
			return $render;
		});
	}
});

//annotations
$app->register(new DDesrosiers\SilexAnnotations\AnnotationServiceProvider(), array(
	'annot.cache' => new Doctrine\Common\Cache\FilesystemCache(__DIR__ . '/cache'),
	'annot.controllerDir' => __DIR__ . '/src',
	'annot.controllerNamespace' => ''
));
