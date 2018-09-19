<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/5/15
 * Time: 10:54
 */

namespace year\editor;


use year\base\AssetBundle;

/**
 * @see https://github.com/josdejong/jsoneditor
 *
 * TODO 暂时没空实现 这个可以用来做api测试工具的开发 在线编辑结构
 *
 * Class JSONEditorAsset
 * @package year\editor
 */
class JSONEditorAsset extends AssetBundle
{


    public $sourcePath = '@year/editor/assets/jsoneditor/dist';
    // public $basePath = '@webroot/assets';
    public $js = [

    ];
    public $css = [
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        // Yii::setAlias('@leptureeditor', __DIR__);
        parent::init();

        if (YII_DEBUG === true) {
            $this->js = [
                'jsoneditor.js'
            ];
            $this->css = [
                'jsoneditor.css'
            ];

        } else {
            $this->js = [
                'jsoneditor.min.js'
            ];
            $this->css = [
                'jsoneditor.min.css'
            ];
        }

    }


}