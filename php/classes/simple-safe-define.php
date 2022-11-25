<?php
class Define
{
    public static $prefix;

    public function __construct(string $prefix = '_FD_', array $array = null)
    {
        self::prefix($prefix);
        if (isset($array)) {
            self::import($array);
        }
    }

    public static function prefix(string $prefix = null)
    {
        if (isset($prefix)) {
            self::$prefix = $prefix;
        } else {
            return self::$prefix;
        }
    }

    public static function define(string $name, string $value, boolean $prefix = true)
    {
        if (isset($name) && isset($value)) {
            if ($prefix) {
                define(self::prefix() . strtoupper($name), base64_encode($value));
            } else {
                define(strtoupper($name), base64_encode($value));
            }
        }
    }

    public static function defined(string $name, boolean $prefix = true)
    {
        if (isset($name)) {
            if ($prefix) {
                return defined(self::prefix() . strtoupper($name));
            } else {
                return defined(strtoupper($name));
            }
        }
    }

    public static function constant(string $name, boolean $prefix = true)
    {
        if (isset($name)) {
            if ($prefix) {
                return base64_decode(constant(self::prefix() . $name));
            } else {
                return base64_decode(constant($name));
            }
        }
    }

    public static function import(array $array)
    {
        foreach ($array as $key => $value) {
            self::define($key, $value);
        }
    }
}
?>