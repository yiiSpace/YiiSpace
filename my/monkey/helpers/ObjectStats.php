<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/4
 * Time: 17:04
 */

namespace monkey\helpers;


class ObjectStats
{
    public static $objectStats = [] ;


    /**
     * @param $class
     * @return int|mixed
     */
    public static function incrementObject($class)
    {
       $classStats =   self::$objectStats[$class]??0 ;
       $classStats++ ;
      return self::$objectStats[$class] = $classStats ;
    }

    /**
     * @param string $class
     */
    public static function printObjectStats($class='')
    {
        echo "\t", 'class' , "\t" , 'count' ,PHP_EOL ;
        foreach (self::$objectStats as $class => $count){
            echo "\t", $class , "\t" , $count ,PHP_EOL;
        }
        echo PHP_EOL ;
    }
}