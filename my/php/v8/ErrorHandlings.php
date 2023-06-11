<?php

namespace my\php\v8;

/**
 * In PHP 8, however, the Warning has been promoted to an Error
 *
 *  Notice-to-Warning promotion
 * • Non-existent object property access attempts
 * • Non-existent static property access attempts
 * • Attempt to access an array element using a non-existent key
 * • Misusing a resource as an array offset
 * • Ambiguous string offset cast
 * • Non-existent or uninitialized string offset
 *
 * https://wiki.php.net/rfc/engine_warnings.
 * https://www.php.net/ manual/en/language.operators.errorcontrol.php.
 * If an error message appears, the best solution is to fix the error, not to silence it!
 *
 * 最佳实践：
 * - Best practice: Do not use the @ error control operator! 
 * 
 */
class ErrorHandlings
{

    /**
     * 未定义错误在php8中提升为warnning 7中是notice
     *
     * @return void
     */
    public static function UndefinedVariable()
    {
        $c = $a + $b;
        var_dump($c);
    }

    /**
     * Undocumented function
     *
     * If you plan to use constants, it's also a good idea to define them as soon as possible,
     * preferably in one place.
     *
     * @return void
     */
    public static function undefConstants()
    {
        echo PHP_OS . "\n";
        echo UNDEFINED_CONSTANT . "\n";
        echo "Program Continues ... \n";
    }

    public static function nullObject()
    {
        try {
            $a->test = 0;
            $a->test++;
            var_dump($a);
        } catch (\Error $e) {
            error_log(__FILE__ . ':' . $e->getMessage());
            // 可以重抛！
            throw new \ErrorException ($e->getMessage(), $e->getCode());
        }
    }

    public static function arrErrors()
    {
        // Next element already occupied
        $a[PHP_INT_MAX] = 'This is the end!';
        $a[] = 'Off the deep end';

        // Offsets in non-array variables
        $url = 'https://unlikelysource.com/';
        if ($url[-1] == '/') {
            $url = substr($url, 0, -1);
        }

        echo $url;
    }

    /**
     * Illegal offset types
     *
     * - integer keys : numeric array
     *
     * -  string keys : associative array
     * @return void
     *
     * in PHP 7 and earlier the code example completes with a Warning, whereas in PHP 8 an Error is thrown.
     *
     * 最佳实践：
     * Best practice: When initializing an array, be sure that the array index data type is either an integer or a string.
     */
    public static function arrIllegalOffset()
    {
        $x = (float) 22 / 7;
        $arr[$x] = 'Value of Pi';

        //
        $obj = new \stdClass ();
        $b = ['A' => 1, 'B' => 2, $obj => 3];
        var_dump($b);

        // 原因 同上
        $obj = new \stdClass ();
        $b = ['A' => 1, 'B' => 2, 'C' => 3];
        unset($b[$obj]);
        var_dump($b);

        // illegal offsets in empty() or isset()
        $obj = new \stdClass ();
        $obj->c = 'C';
        $b = ['A' => 1, 'B' => 2, 'C' => 3];
        $message = (empty($b[$obj])) ? 'NOT FOUND' : 'FOUND';
        echo "$message\n";
    }
}

namespace ForString;

/**
 * Promoted warnings in string handling
 *
 *  promoted warnings pertaining to objects and arrays also applies to PHP 8 string error handling.
 */

/**
 * Undocumented function
 *
 * @return void
 * php8: ValueError
 */
function php8_error_str_pos()
{
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    echo $str[strpos($str, 'Z', 0)];
    echo $str[strpos($str, 'Z', 27)];
}

function php8_error_str_empty()
{
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str[5] = '';
    echo $str . "\n";
}

function php8_warn_undef_prop()
{
    class Test
    {
        public static $stat = 'STATIC';
        public $exists = 'NORMAL';
    }
    $obj = new Test();
    echo $obj->exists;
    echo $obj->does_not_exist;

    try {
        echo Test::$stat;
        echo Test::$does_not_exist;
    } catch (\Error $e) {
        echo __LINE__ . ':' . $e;
    }
}

/**
 * in general, Notices have been promoted to Warnings where data is read,
 *  whereas Warnings have been promoted to Errors where data is written (and could conceivably result in lost data)
 */
function php8_warn_undef_array_key()
{
    $key = 'ABCDEF';
    $vals = ['A' => 111, 'B' => 222, 'C' => 333];
    echo $vals[$key[6]];
}

/**
 *
 *
 * Note that in PHP 8, many functions that formerly produced a resource now produce an object instead
 *
 * @return void
 *
 * Best practice: Do not use resource IDs as array offsets!
 */
function php8_warn_resource_offset()
{
    $fn = __DIR__ . '/../sample_data/gettysburg.txt';
    $fh = fopen($fn, 'r');
    echo $fh . "\n";
    // ? try to use the resource ID as an array offset,
}

function php8_warn_amb_offset()
{
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $ptr = [null, true, 22 / 7];
    foreach ($ptr as $key) {
        var_dump($key);
        echo $str[$key];
    }
}

/**
 * Uninitialized or non-existent string offsets
 *
 * @return void
 */
function php8_warn_un_init_offset()
{
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    echo $str[27];
}

namespace error_control_operator;

function bad()
{
    trigger_error(__FUNCTION__, E_USER_ERROR);
}
function worse()
{
    return include __DIR__ . '/includes/
    causes_parse_error.php';
}
function php8_at_silencer()
{
    echo @bad();
    echo @worse();
    echo "\nLast Line\n";
}

/**
 *  error_reporting() returns the value of the last error
 * 
 * in that error_reporting() returned a value of 0 if the
 * `@` operator was used.
 * 
function bad() {
trigger_error('We Be Bad', E_USER_ERROR);
}
set_error_handler('handler');
echo @bad();
 */

function handler(int $errno, string $errstr)
{
    $report = error_reporting();
    echo 'Error Reporting : ' . $report . "\n";
    echo 'Error Number : ' . $errno . "\n";
    echo 'Error String : ' . $errstr . "\n";
    if (error_reporting() == 0) {
        echo "IF statement works!\n";
    }
}
