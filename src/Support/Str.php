<?php
declare(strict_types=1);

namespace Shampine\Sequence\Support;

class Str
{
    /**
     * @param string $str
     * @return string
     */
    public static function snakeCase(string $str): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $str) ?? '');
    }

    /**
     * @param string $str
     * @return string
     */
    public static function studlyCase(string $str): string
    {
        return ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $str))));
    }

    /**
     * @param string $str
     * @return string
     */
    public static function getter(string $str): string
    {
        return 'get' . self::studlyCase($str);
    }

    /**
     * @param string $str
     * @return string
     */
    public static function setter(string $str): string
    {
        return 'set' . self::studlyCase($str);
    }
}
