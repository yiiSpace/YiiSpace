<?php

namespace common\widgets;

use yii\web\AssetBundle;

class AoFormAsset extends   AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = __DIR__.'/assets/aoform/dist';

    /**
     * @var array
     */
    public $js = [
        'aoform.min.js'
    ];

    /**
     * @var array
     */
    public $css = [
        'aoform.min.css',
    ];

    public $depends = [
//        'yii\web\JqueryAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];

}