<?php

function env($parameter,$default = null){
    return $_ENV[$parameter] ?? $default;
}

class Args{

    private static $arguments;

    public static function set(array $args)
    {
        self::$arguments = $args;
    }

    public static function get($arg,bool $default = false){

        return in_array('-'.$arg, self::$arguments);
    }
}