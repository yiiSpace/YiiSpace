<?php

namespace common\widgets;

use yii\web\AssetBundle;

class OutperFormAsset extends   AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = __DIR__.'/assets/outperform';

    /**
     * @var array
     */
    public $js = [
        // 'jquery.fancytree-all.min.js'
        'outperform.js'
    ];

    /**
     * @var array
     */
    public $css = [
//        'jquery.bxslider.css',
    ];

    public $depends = [
//        'yii\web\JqueryAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];

}