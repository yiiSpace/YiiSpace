<?php

namespace my\php\v8;

/**
 * - In PHP 8, you can no longer call a non-static method using a static method call
 */

class StaticsDemo
{

}

class Test
{
    public function notStatic()
    {
        return __CLASS__ . PHP_EOL;
    }
}
// echo Test::notStatic(); // PHP Fatal error: Uncaught Error: Non-static method

function php8_oop_diff_array_key_exists()
{
    $obj = new class()
    {public $var = 'OK.';};

    $default = 'DEFAULT';
    echo (isset($obj->var))
    ? $obj->var : $default;
    echo (property_exists($obj, 'var'))
    ? $obj->var : $default;
    echo (array_key_exists('var', $obj))
    ? $obj->var : $default;
}
