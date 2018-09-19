<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-10
 * Time: 下午1:26
 */

namespace year\ui;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * @see https://github.com/usmanhalalit/charisma
 *
 * Class CharismaAsset
 * @package year\ui
 */
class CharismaAsset extends AssetBundle{
    /*
        public $basePath = '@webroot';
        public $baseUrl = '@web';
        */
    public $sourcePath =  '@year/ui/assets/charisma';
    public $css = [
        // 'css/site.css',
        //  'adminlte/css/AdminLTE.css', // THIS CHANGE
    ];
    public $js = [
    ];
    /**
     * 如果不发布任何js 那么下面的js依赖也不会被发布
     *
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
       //  'yii\bootstrap\BootstrapAsset',
    ];

    /**
     * 这个地方放在body部分也可以哦！
     * @var array
     */
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
} 