<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/4/18
 * Time: 7:28
 */

namespace year\gii\nodetest;

use yii\base\InvalidConfigException;

/**
 * 从  Yii::$app->params['<configKey>'] 取值
 */
const ConfigKey = 'nodetest.config';

/**
 * Class Config
 *
 * TODO 如果配置属性太多了 干脆弄成组件形式
 * @package year\gii\nodetest
 */
class Config
{
    /**
     * @param string $appParamKey
     * @return string
     */
    public static function getConfig($appParamKey = ConfigKey)
    {
        if (!empty(\Yii::$app->params[$appParamKey])) {
            return \Yii::$app->params[$appParamKey] ;
        } else {
            // throw  new  InvalidConfigException("you need some config for using ") ;

        }
    }

}