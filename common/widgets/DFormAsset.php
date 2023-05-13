<?php

namespace common\widgets;

use yii\web\AssetBundle;

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