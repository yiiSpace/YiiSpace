<?php
/**
 * User: yiqing
 * Date: 14-9-9
 * Time: 下午7:44
 */

namespace year\ui;

use yii\web\View ;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminLTEAsset extends AssetBundle
{
    /*
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    */
    public $sourcePath =  '@year/ui/assets/AdminLTE';
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