<?php

namespace App\Utils;

class Utils
{
    /**
     * Returns a variable if the variable is set, else returns the fallback.
     * This is a shorthand for doing something like this:
     * $variable = isset( $array['key'] ) ? $array['key'] : 'fallback value'
     */
    public static function getIfSet(?string &$var, string $fallback = '')
    {
        return isset($var) ? $var : $fallback;
    }
}
