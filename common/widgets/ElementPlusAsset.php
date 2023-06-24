<?php 
namespace common\widgets;


use yii\web\AssetBundle;
/**
 * fixme： 需要跟踪版本么 还是把版本也暴露成用户可以设置的
 */
class ElementPlusAsset extends AssetBundle
{
    public $sourcePath = null;
    public $js = [
        'https://unpkg.com/element-plus@2.1.9/dist/index.full.js',
    ];
    public $css = [
        'https://unpkg.com/element-plus@2.1.9/dist/index.css',
    ];

    public $depends = [
        VueAsset::class,
    ];
}