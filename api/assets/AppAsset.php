<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\View;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
       // 'css/site.css',
    ];
    public $js = [
        'js/jquery.browser.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',

    ];
    /**
     * 这个地方放在body部分也可以哦！
     * @var array
     */
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];

    /**
     * @param null $view
     * @return static
     */
    public static function registerAsset($view=null)
    {
        static $appAsset = null ;
        if($appAsset !== null)
        {
            return $appAsset ;
        }
        if(empty($view)){
            $view = \Yii::$app->view ;
        }
        $appAsset = AppAsset::register($view);
        return $appAsset ;
    }

    /**
     * @return string
     */
    public static function getBaseUrl()
    {
         $appAsset = self::registerAsset();
        return $appAsset->baseUrl ;
    }
}
