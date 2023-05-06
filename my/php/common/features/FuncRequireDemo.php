<?php

namespace my\php\common\features;

class FuncRequireDemo
{
    /**
     * NOTE 坑说名 require 会影响当前函数中可用的变量名 所以如果存在同名现象 就会覆盖掉 这个坑很难找
     * 还有 require跟require_once 的区别
     * 以及include include_once 区别
     *
     * include 文件名不存在 是报warnning
     *
     * require会报 fatal error
     *
     * 各种奇葩现象
     * @see https://www.php.net/manual/en/function.require-once.php#127107
     *
     * @param $params
     * @return void
     */
    public static function run($params= 'something')
    {
        dump(get_defined_vars());
        $config0 = (function() {return \yii\helpers\ArrayHelper::merge(
            require( \Yii::getAlias('@common/config/main.php')),
            require( \Yii::getAlias('@console/config/main.php'))
        );})();

        dump(get_defined_vars());

        $config = \yii\helpers\ArrayHelper::merge(
            require( \Yii::getAlias('@common/config/main.php')),
            require( \Yii::getAlias('@console/config/main.php'))
        );
        dump(get_defined_vars());
        dump($params);
    }

}