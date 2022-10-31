<?php

namespace Kubinyete\Fraugster\Util;

abstract class ArrayUtil
{
    private const SEPARATOR = '.';

    public static function get(string $path, array $array, mixed $default = null): mixed
    {
        $splitPath = explode(self::SEPARATOR, $path);

        while (is_array($array) && ($key = array_shift($splitPath))) {
            if (array_key_exists($key, $array)) {
                $array = &$array[$key];
            } else {
                $array = null;
            }
        }

        return is_null($array) || !empty($splitPath) ? $default : $array;
    }
}
