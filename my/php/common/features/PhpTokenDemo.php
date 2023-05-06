<?php

namespace my\php\common\features;

/**
 * @see https://www.php.net/phptoken
 * @see https://github.com/php/php-langspec/blob/master/spec/14-classes.md#class-declarations
 *
 */
class PhpTokenDemo
{
    /**
     * @see https://stackoverflow.com/questions/7153000/get-class-name-from-file
     *
     * @return void
     */
    public static function run()
    {
//        $file      = 'whatever.php';
        $file = __FILE__;
        $classes = [];
        $namespace = '';
        $tokens = \PhpToken::tokenize(file_get_contents($file));

        for ($i = 0; $i < count($tokens); $i++) {
            if ($tokens[$i]->getTokenName() === 'T_NAMESPACE') {
                for ($j = $i + 1; $j < count($tokens); $j++) {
                    if ($tokens[$j]->getTokenName() === 'T_NAME_QUALIFIED') {
                        $namespace = $tokens[$j]->text;
                        break;
                    }
                }
            }

            if ($tokens[$i]->getTokenName() === 'T_CLASS') {
                for ($j = $i + 1; $j < count($tokens); $j++) {
                    if ($tokens[$j]->getTokenName() === 'T_WHITESPACE') {
                        continue;
                    }

                    if ($tokens[$j]->getTokenName() === 'T_STRING') {
                        $classes[] = $namespace . '\\' . $tokens[$j]->text;
                    } else {
                        break;
                    }
                }
            }
        }

// Contains all FQCNs found in a file.
        $classes;
        dump($classes);
    }

    public static function getClasses()
    {
//        dump(MyClassFinder::getAllClasses(__FILE__));
        dump(file_get_php_classes(__FILE__));
    }
}

class MyClassFinder
{
    /**
     * @see https://stackoverflow.com/questions/7153000/get-class-name-from-file
     *
     * hint: If you're looking for a class which is derived of a specific one, use is_subclass_of
     *
     * @param $file –  Name of the file to read.
     * @return array
     *
     * FIXME: 返回的东西有很多重复
     */
    public static function getAllClasses($file)
    {
        $php_code = file_get_contents($file);
        $classes = array();
        $namespace = "";
        $tokens = token_get_all($php_code);
        $count = count($tokens);

        for ($i = 0; $i < $count; $i++) {
            if ($tokens[$i][0] === T_NAMESPACE) {
                for ($j = $i + 1; $j < $count; ++$j) {
                    if ($tokens[$j][0] === T_STRING)
                        $namespace .= "\\" . $tokens[$j][1];
                    elseif ($tokens[$j] === '{' or $tokens[$j] === ';')
                        break;
                }
            }
            if ($tokens[$i][0] === T_CLASS) {
                for ($j = $i + 1; $j < $count; ++$j)
                    if ($tokens[$j] === '{') {
                        $classes[] = $namespace . "\\" . $tokens[$i + 2][1];
                    }
            }
        }
        return $classes;
    }
}


/**
 * @see https://stackoverflow.com/questions/928928/determining-what-classes-are-defined-in-a-php-class-file
 *
 * @param $filepath
 * @return array
 */
function file_get_php_classes($filepath) {
    $php_code = file_get_contents($filepath);
    $classes = get_php_classes($php_code);
    return $classes;
}

/**
 * @param $php_code
 * @return array
 */
function get_php_classes($php_code) {
    $classes = array();
    $tokens = token_get_all($php_code);
    $count = count($tokens);
    for ($i = 2; $i < $count; $i++) {
        if (   $tokens[$i - 2][0] == T_CLASS
            && $tokens[$i - 1][0] == T_WHITESPACE
            && $tokens[$i][0] == T_STRING) {

            $class_name = $tokens[$i][1];
            $classes[] = $class_name;
        }
    }
    return $classes;
}