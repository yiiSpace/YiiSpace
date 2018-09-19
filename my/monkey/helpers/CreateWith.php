<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/1
 * Time: 14:18
 */

namespace monkey\helpers;


/**
 * Trait CreateWith
 * @package monkey\helpers
 */
trait CreateWith
{

    /**
     * @param array $config
     * @return static
     */
    public static function CreateWith($config = [])
    {
        //\Yii::createObject()
        $obj = new static();
        foreach ($config as $attr => $val) {
            $obj->{$attr} = $val;
        }

        ObjectStats::incrementObject(static::class) ;

        return $obj;
    }
}