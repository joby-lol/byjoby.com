<?php

namespace CoreBundle;

use Symfony\Component\HttpFoundation\Response;

/**
 * Description of ErrorHandler
 *
 * @author elhober
 */
class ErrorHandler
{

	public static function handle($e, $code, $app)
	{
		$eclass = preg_replace("/^.+\\\/", '', get_class($e));
		$template = 'error/default.twig';
		$classTemplate = 'error/class/' . $eclass . '.twig';
		$codeTemplate = 'error/code/' . $code . '.twig';
		if ($app['twig']->getLoader()->exists($codeTemplate)) {
			$template = $codeTemplate;
		}
		if ($app['twig']->getLoader()->exists($classTemplate)) {
			$template = $classTemplate;
		}
		$fields = array(
			'e' => $e,
			'eclass' => $eclass,
			'code' => $code
		);
		return new Response($app['twig']->render($template, $fields));
	}

}
