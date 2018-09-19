<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/4/18
 * Time: 7:28
 */

namespace year\gii\yunying;

/** @var string 辅助go服务的基地址 如 http://localhost:1323 */
use yii\base\InvalidConfigException;

const GiiBaseUrlKey = 'yunying.giiBaseUrl';

/**
 * Class Config
 *
 * TODO 如果配置属性太多了 干脆弄成组件形式
 * bootstrap'=>[
 *      [
 *         'class'=>'year\gii\yunying\Bootstrap',
 *          'configId'=>'yunying.config'',
 *          'config'=> [
 *                 'class'=> 'year\gii\yunying\Config',
 *                 'giiBaseBurl'=>'http://localhost:1323',
 *
 *
 * @package year\gii\yunying
 */
class Config
{
    /**
     * @param string $appParamKey
     * @return string
     */
    public static function goGiiBaseUrl($appParamKey = GiiBaseUrlKey)
    {
        if (!empty(\Yii::$app->params[$appParamKey])) {
            return rtrim(\Yii::$app->params[$appParamKey], '/');
        } else {
            // throw  new  InvalidConfigException("you need config the yunying gii-base-url ") ;
            return 'http://localhost:1323';
        }
    }

    /**
     * @return bool|string
     */
    public static function getProjectHome()
    {

        $giiEndpoint = static::goGiiBaseUrl() . ' /gii/project-home';
        return trim(file_get_contents($giiEndpoint));

    }
}