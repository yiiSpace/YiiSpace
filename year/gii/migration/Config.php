<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/4/18
 * Time: 7:28
 */

namespace year\gii\migration;

/** @var string 辅助go服务的基地址 如 http://localhost:1323 */
use yii\base\InvalidConfigException;

const GiiBaseUrlKey = 'migration.giiBaseUrl';

/**
 * Class Config
 *
 * TODO 如果配置属性太多了 干脆弄成组件形式
 * bootstrap'=>[
 *      [
 *         'class'=>'year\gii\migration\Bootstrap',
 *          'configId'=>'migration.config'',
 *          'config'=> [
 *                 'class'=> 'year\gii\migration\Config',
 *                 'giiBaseBurl'=>'http://localhost:1323',
 *
 *
 * @package year\gii\migration
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
            // throw  new  InvalidConfigException("you need config the migration gii-base-url ") ;
            return 'http://localhost:1323';
        }
    }

}