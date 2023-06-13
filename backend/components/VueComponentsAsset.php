<?php
 
namespace backend\components;

use yii\web\AssetBundle;

/**
 * This declares the asset files required by Gii.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class VueComponentsAsset extends AssetBundle
{
    public $sourcePath = '@backend/components-vue';
    public $css = [
        // 'css/main.css',
    ];
    public $js = [
        // 'js/bs4-native.min.js',
        // 'js/gii.js',
    ];
    public $depends = [
        // 'yii\web\YiiAsset'
    ];
}
