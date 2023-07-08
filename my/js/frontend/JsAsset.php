<?php
namespace my\js\frontend;

use yii\web\AssetBundle;

/**
 * This declares the asset files required by Js module.
 *
 * @author qing <yiqing_95@qq.com>
 * @since 1.0
 */
class JsAsset extends AssetBundle
{
    public $sourcePath = __DIR__.'/assets';
   
    // 强迫资源发布 仅在开发模式下
    /**
     * Summary of publishOptions
     * @var array
     */
    public $publishOptions = [
        'forceCopy'=> true ,//YII_DEBUG ,
    ];
}
