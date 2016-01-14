<?php

namespace CoreBundle;

class ContentBuilder
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
		//special handling for .link files, they bounce
		if ($extension == 'link') {
			$url = file($path);
			return new \Symfony\Component\HttpFoundation\RedirectResponse(trim($url[0]));
		}
		//handle files that have a twig template
		$template = 'ContentBuilder/' . $extension . '.twig';
		if (!$this->app['twig']->getLoader()->exists($template)) {
			return false;
		}
		$fields = $this->app['config']['fields'];
		//load YAML front matter
		$parser = new \Mni\FrontYAML\Parser();
		$document = $parser->parse(file_get_contents($path));
		$yaml = $document->getYAML();
		if ($yaml) {
			$fields = array_replace_recursive($fields, $document->getYAML());
		}
		$fields['pageBody'] = $document->getContent();
		return $this->app['twig']->render($template, $fields);
	}

	function path($url)
	{
		if ($url == '/') {
			$url = '';
		}
		$globPath = $this->app['appDir'] . '/' . $this->app['config']['content']['path'] . $url;
		$globPath = preg_replace('/\/$/', '', $globPath);
		$globs = array(
			$globPath . '/index.*',
			$globPath . '.*'
		);
		$candidates = array();
		foreach ($globs as $glob) {
			$candidates = $candidates + glob($glob);
		}
		if (count($candidates) == 0) {
			return false;
		}
		return $candidates[0];
	}

}
