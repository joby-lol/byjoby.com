<?php
namespace byjoby\Templates;

use byjoby\Config;

class TwigManager
{
    protected static $twig;
    protected static $twigLoader;
    protected static $fields = array();

    public static function init()
    {
        if (!isset(self::$twig)) {
            //initialize twig loader
            self::$twigLoader = new \Twig_Loader_Filesystem(
                Config::get('Twig/paths')
            );
            //set up config
            $config = array(
                'cache'       => Config::cache('twig'),
                'auto_reload' => true,
            );
            //initialize twig environment
            self::$twig = new \Twig_Environment(
                self::$twigLoader,
                $config
            );
            //load default fields
            self::set(Config::get('fields'));
        }
    }

    public static function set($new)
    {
        self::init();
        if (is_array($new)) {
            self::$fields = array_replace_recursive(self::$fields, $new);
        }
    }

    public static function exists($template)
    {
        self::init();
        return self::$twigLoader->exists($template);
    }

    public static function render($template, $fields = array())
    {
        $fields = array_replace_recursive(self::$fields, $fields);
        $loader = self::$twigLoader;
        $twig   = self::$twig;
        //render
        $output = $twig->render(
            $template,
            $fields
        );
        //return
        return $output;
    }
}
