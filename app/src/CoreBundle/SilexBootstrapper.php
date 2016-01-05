<?php

namespace CoreBundle;

class SilexBootstrapper
{

	private $app;

	function __construct($app)
	{
		$this->app = $app;
	}

	public function boot()
	{
		$app = $this->app;
		//twig
		$app->register(new \Silex\Provider\TwigServiceProvider(), array(
			'twig.path' => $app['appDir'] . '/' . $app['config.twig.path']
		));
		//twig markdown
		$app['twig']->addExtension(
				new \Aptoma\Twig\Extension\MarkdownExtension(
				new \Aptoma\Twig\Extension\MarkdownEngine\MichelfMarkdownEngine()));
		//monolog
		$app->register(new \Silex\Provider\MonologServiceProvider(), array(
			'monolog.logfile' => $app['appDir'] . '/' . $app['config.monolog.logfile'],
			'monolog.level' => $app['config.monolog.level']
		));
		//error handler
		$app->error(function($e, $code) use ($app) {
			if (!$app['debug']) {
				return $app['config.errorHandler']::handle($e, $code, $app);
			}
			echo "<div style='padding:10px;text-align:center;color:#000;background:#ff0;'><strong>Note:</strong> custom error pages do not appear when debug is on.</div>";
		});
	}

	function loadConfig($config, $prefix)
	{
		if (is_array($config)) {
			foreach ($config as $key => $value) {
				if (is_array($value) && $this->isAssoc($value)) {
					$this->loadConfig($value, $prefix . $key . '.');
				} else {
					$this->setConfig($prefix . $key, $value);
				}
			}
		}
	}

	function isAssoc($arr)
	{
		return array_keys($arr) !== range(0, count($arr) - 1);
	}

	function setConfig($key, $value)
	{
		$this->app[$key] = $value;
	}

}
