<?php
/**
 * User: yiqing
 * Date: 2014/10/12
 * Time: 21:51
 */

namespace year\editor;

use yii\web\AssetBundle;
use yii;

/**
 * TODO 有些bug 可能是jquery版本问题！
 *
 *
 * Class XHEditorAssets
 * @package year\editor
 */
class XHEditorAssets extends AssetBundle
{
    public $sourcePath = '@year/editor/assets/xheditor-1.2.1';
    // public $basePath = '@webroot/assets';
    public $js = [
        'xheditor-1.2.1.min.js',
        'xheditor_lang/zh-cn.js',
    ];
    public $css = [
        // 'css/editor.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'app\assets\AppAsset'
    ];

    public function init()
    {
        // Yii::setAlias('@leptureeditor', __DIR__);
        return parent::init();
    }
}