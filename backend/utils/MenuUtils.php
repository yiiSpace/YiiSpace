<?php

namespace backend\utils;

use Faker\Factory;
use Yii ;

class MenuUtils
{
    public static function getModules()
    {
        $topModules = [] ;


       return  Yii::$app->getModules();
    }

    /**
     * Undocumented function
     *
     * @param string $moduleId
     * @return void
     */
    public static function getControllersOfModule($moduleId = '')
    {
        $facker = Factory::create();
//            $facker->
    }
}