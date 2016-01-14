<?php

namespace CoreBundle;

class PassthroughBuilder
{

	var $app;

	function __construct($app)
	{
		$this->app = $app;
	}

	function render($url)
	{
		$path = $this->path($url);
		if (!$path) {
			return false;
		}
		return $this->renderContent($path);
	}

	function renderContent($path)
	{
		$extension = explode('.', $path);
		$extension = array_pop($extension);
		//handle files that are pass throughs
		if (isset($this->app['config']['content']['static'][$extension])) {
			return $this->app->stream(function() use($path) {
						readfile($path);
					}, 200, array('Content-Type' => $this->app['config']['content']['static'][$extension]));
		}
	}

	function path($url)
	{
		if ($url == '/') {
			$url = '';
		}
		$path = $this->app['appDir'] . '/' . $this->app['config']['content']['path'] . $url;
		if (is_file($path)) {
			return $path;
		}
		return false;
	}

}
