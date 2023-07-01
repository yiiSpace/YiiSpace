<?php
 
namespace backend\components;

use yii\web\AssetBundle;

/**
 * This declares the asset files required by Vue views.
 *
 * @author qing <yiqing_95@qq.com>
 * @since 0.1
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
