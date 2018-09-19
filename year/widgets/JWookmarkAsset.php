<?php
/**
 * User: yiqing
 * Date: 14-8-22
 * Time: 下午12:36
 */

namespace year\widgets;

use yii\web\AssetBundle ;

class JWookmarkAsset extends AssetBundle
{

    public $sourcePath = '@year/widgets/assets/Wookmark-jQuery';

    public $js = [
        // 'jquery.fancytree-all.min.js'
        'js/jquery.wookmark.min.js'
    ];

    public $css = [
        // 'css/main.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];


}