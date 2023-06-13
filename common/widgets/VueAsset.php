<?php
 
namespace common\widgets;

use yii\web\AssetBundle;

/**
 * This asset bundle provides the vue files .
 *
 * @author qing <yiqing_95@qq.com>
 * @since 0.0.1
 * 
 * 关于如何使用AssetBundle 以及如何替换官方配置 参考
 * https://www.yiiframework.com/extension/yiisoft/yii2-bootstrap4/doc/guide/2.0/en/assets-setup
 * 
 */
class VueAsset extends AssetBundle
{
    public $sourcePath = '@npm/vue';
    public $js = [
        'dist/vue.global.js',
    ];
    public $depends = [
        
    ];
}
