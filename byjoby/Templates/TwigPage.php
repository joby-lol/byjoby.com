<?php
namespace byjoby\Templates;

class TwigPage
{
    protected static $template;
    protected static $fields = array();

    public static function template($template)
    {
        if (TwigManager::exists($template)) {
            self::$template = $template;
        }
    }

    public static function set($fields)
    {
        if (is_array($fields)) {
            self::$fields = array_replace_recursive(self::$fields, $fields);
        }
    }

    public static function render($body, $fields = array())
    {
        $fields['page_body'] = $body;
        return TwigManager::render(
            self::$template,
            array_replace_recursive(self::$fields, $fields)
        );
    }
}
