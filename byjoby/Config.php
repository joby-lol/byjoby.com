<?php
namespace byjoby;

use Symfony\Component\Yaml\Yaml;

class Config
{
    public static $paths = array();
    public static $data  = array();

    public static function get($name)
    {
        self::load($name);
        $name  = self::sanitize($name);
        $parts = explode('/', $name);
        $p     = &self::$data;
        foreach ($parts as $key) {
            if (!array_key_exists($key, $p)) {
                return false;
            }
            $p = &$p[$key];
        }
        return self::clean($p);
    }

    public static function set($name, $value)
    {
        self::load($name);
        $name  = self::sanitize($name);
        $parts = explode('/', $name);
        $p     = &self::$data;
        foreach ($parts as $key) {
            if (!array_key_exists($key, $p)) {
                $p[$key] = array();
            }
            $p = &$p[$key];
        }
        $p = $value;
    }

    public static function cache($name)
    {
        if (!self::get('site/cache')) {
            return false;
        }
        if (!is_dir(self::get('site/cache')) || !is_writeable(self::get('site/cache'))) {
            return false;
        }
        $path = self::get('site/cache') . '/' . $name;
        if (!is_dir($path) && !mkdir($path)) {
            return false;
        }
        if (!is_writeable($path)) {
            return false;
        }
        return $path;
    }

    protected static function clean($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::clean($value);
            }
        } elseif (is_string($data)) {
            $data = preg_replace_callback('/%[a-z0-9\-_\/]+%/i', function ($match) {
                $match = str_replace('%', '', $match[0]);
                $data  = self::get($match);
                if (is_string($data)) {
                    return $data;
                }
                return '%' . $match . '%';
            }, $data);
        }
        return $data;
    }

    protected static function load($name)
    {
        $name  = self::sanitize($name);
        $parts = explode('/', $name);
        foreach (self::$paths as $configDir) {
            $loc = array();
            foreach ($parts as $part) {
                $loc[] = $part;
                $configDir .= '/' . $part;
                $file = $configDir . '.yaml';
                if (is_file($file) && is_readable($file)) {
                    self::loadFile(implode('/', $loc), $file);
                }
                if (!is_dir($configDir)) {
                    break;
                }
            }
        }
    }

    protected static function loadFile($loc, $file)
    {
        $data = Yaml::parse(file_get_contents($file));
        self::loadData($loc, $data);
    }

    protected static function loadData($loc, $data)
    {
        $loc = explode('/', $loc);
        $p   = &self::$data;
        foreach ($loc as $key) {
            if (!array_key_exists($key, $p)) {
                $p[$key] = array();
            }
            $p = &$p[$key];
        }
        if (is_array($data)) {
            $p = array_replace_recursive($p, $data);
        } else {
            $p = $data;
        }
    }

    protected static function sanitize($name)
    {
        $name = strtolower($name);
        $name = preg_replace('/[^a-z0-9\-_\/]/', '', $name);
        $name = preg_replace('/\/+/', '/', $name);
        return $name;
    }
}
