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
        $content             = TwigManager::render(
            self::$template,
            array_replace_recursive(self::$fields, $fields)
        );
        $regexp  = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
        $content = preg_replace_callback("/$regexp/siU", function ($matches) {
            $text = $matches[0];
            if (
                ($matches[2] != '/' && strpos($_SERVER['REQUEST_URI'], $matches[2]) === 0) ||
                $matches[2] == $_SERVER['REQUEST_URI']
            ) {
                $text = str_replace('<a ', '<a aria-selected="true" ', $text);
            }
            return $text;
        }, $content);
        echo $content;
    }
}
