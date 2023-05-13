<?php

namespace common\widgets;

use yii\web\AssetBundle;

/**
 *
 * 另外的一个库 但是这个好像依赖比较多
 * https://github.com/jsonform/jsonform
 */
class JsonFormsAsset  extends   AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = __DIR__.'/assets/json-forms/dist';

    /**
     * @var array
     */
    public $js = [
        // 'jquery.fancytree-all.min.js'
        'js/brutusin-json-forms.min.js',
//        'brutusin-json-forms-bootstrap.min.js',
    ];

    /**
     * @var array
     */
    public $css = [
//        'jquery.bxslider.css',
    'css/brutusin-json-forms.min.css',
    ];
}