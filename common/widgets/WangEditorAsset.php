<?php
 
namespace common\widgets;

use yii\web\AssetBundle;

/**
 * This asset bundle provides the waneditor asset files .
 * @see https://www.wangeditor.com/v5/installation.html#npm
 *
 * @author qing <yiqing_95@qq.com>
 * @since 0.0.1
 * 
 * 关于如何使用AssetBundle 以及如何替换官方配置 参考
 * https://www.yiiframework.com/extension/yiisoft/yii2-bootstrap4/doc/guide/2.0/en/assets-setup
 * 
 * https://www.yiiframework.com/doc/guide/2.0/en/structure-assets
 */
class WangEditorAsset extends AssetBundle
{
    public $sourcePath = null ; // '@npm/wangeditor/editor';
    public $css = [
        'https://unpkg.com/@wangeditor/editor@latest/dist/css/style.css',
    ];
    public $js = [
        'https://unpkg.com/@wangeditor/editor@latest/dist/index.js',
    ];
    public $depends = [
        
    ];
}
