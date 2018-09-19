<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-10
 * Time: 上午11:15
 */

namespace year\ui;

use yii\web\View ;
use yii\web\AssetBundle;

/**
 * TODO 这是一个很好的备选UI
 * Class BCoreAdminAsset
 * @package year\ui
 */
class BCoreAdminAsset extends AssetBundle
{
    /*
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    */
    public $sourcePath =  '@year/ui/assets/bs-admin-bcore/template';
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

    /**
     * 这个地方放在body部分也可以哦！
     * @var array
     */
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
} 