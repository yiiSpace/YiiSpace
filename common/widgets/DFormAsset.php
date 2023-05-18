<?php

namespace common\widgets;

use yii\web\AssetBundle;

/**
 * 这个库看起来不错 扩展性也有 可以使用 或者二次改造
 */
class DFormAsset extends   AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = __DIR__.'/assets/dform/dist';

    /**
     * @var array
     */
    public $js = [
        // 'jquery.fancytree-all.min.js'
        'jquery.dform-1.1.0.min.js'
    ];

    /**
     * @var array
     */
    public $css = [
//        'jquery.bxslider.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];

}