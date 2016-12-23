<?php
require_once __DIR__ . '/vendor/autoload.php';

use \byjoby\Config;
use \byjoby\Templates\TwigManager;
use \byjoby\Templates\TwigPage;

Config::$paths[] = __DIR__ . '/config';
Config::set('rootdir', __DIR__);

TwigManager::init(array(
    'paths' => array(
        __DIR__ . '/templates',
    ),
));

//use templater
if (!defined('PAGE_NOTEMPLATE')) {
    // default template
    $template = Config::get('Twig/template');
    TwigPage::template($template);
    $url = $_SERVER['REQUEST_URI'];
    foreach (Config::get('Twig/template_rules') as $rule) {
        if (preg_match($rule[0], $url)) {
            $template = $rule[1];
            break;
        }
    }
    // set up templating
    TwigPage::template($template);
    ob_start();
    register_shutdown_function(function () {
        $page = ob_get_clean();
        if (TwigPage::$aborted) {
            echo $page;
        } else {
            echo TwigPage::render($page);
        }
    });
}
