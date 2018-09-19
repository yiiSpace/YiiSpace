<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-10
 * Time: 下午1:17
 */

namespace year\ui;


use yii\web\View ;
use yii\web\AssetBundle;

class DevOOPSAsset extends AssetBundle
{
    /*
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    */
    public $sourcePath =  '@year/ui/assets/devoops';
    public $css = [
        // 'css/site.css',
        //  'adminlte/css/AdminLTE.css', // THIS CHANGE
    ];
    public $js = [
        // 'adminlte/js/AdminLTE/app.js' // THIS CHANGE
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
} 