<?php

namespace common\widgets;

use yii\web\AssetBundle;

class DynFormsAsset extends   AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = __DIR__.'/assets/dynforms';

    /**
     * @var array
     */
    public $js = [
        // 'jquery.fancytree-all.min.js'
        ['dist/dynforms.min.js',
//            'async'=>'async',
            'async'=>true,
//            'defer'=>true
//            'position' => View::POS_END,
        ],
    ];

    /**
     * @var array
     */
    public $css = [
//        'jquery.bxslider.css',
    ];
}