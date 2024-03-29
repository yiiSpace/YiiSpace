<?php

namespace common\widgets;

use yii\web\AssetBundle;

/**
 * 相似
 * - https://github.com/dastagirkhan/populatejs
 * - https://github.com/simomosi/dynamic-forms
 */
class EasyJsonFormAsset extends   AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = '@common/widgets/assets/easyjsonform';

    /**
     * @var array
     */
    public $js = [
        // 'jquery.fancytree-all.min.js'
        'easyjsonform.js'
    ];

    /**
     * @var array
     */
    public $css = [
//        'jquery.bxslider.css',
    ];
}