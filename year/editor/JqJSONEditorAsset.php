<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/5/15
 * Time: 10:56
 */

namespace year\editor;


use year\base\AssetBundle;

/**
 * @see https://github.com/cantino/jsoneditor
 *
 * 轻量级json在线编辑器 http://andrewcantino.com/examples/jsoneditor/example.html
 *
 * Class JqJSONEditorAsset
 * @package year\editor
 */
class JqJSONEditorAsset extends AssetBundle
{

    public $sourcePath = '@year/editor/assets/jq-jsoneditor';
    // public $basePath = '@webroot/assets';
    public $js = [
        'build/jquery.json-editor.js',
    ];
    public $css = [
        'build/jquery.json-editor.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        // Yii::setAlias('@leptureeditor', __DIR__);
        return parent::init();
    }

}