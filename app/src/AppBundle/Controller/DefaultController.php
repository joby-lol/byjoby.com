<?php

namespace AppBundle\Controller;

use DDesrosiers\SilexAnnotations\Annotations as SLX;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SLX\Controller()
 */
class DefaultController
{

	/**
	 * @SLX\Request(method="GET", uri="/foo"),
	 *
	 */
	public function testMethod(\Silex\Application $app)
	{
		$template = 'main.twig';
		$fields = array(
			'pageTitle' => 'Title',
			'pageBody' => 'test body'
		);
		return $app['twig']->render($template, $fields);
	}

}
