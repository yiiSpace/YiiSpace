<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/1
 * Time: 15:49
 */

namespace year\editor;


use yii\web\AssetBundle;

class FlexiJsonEditorAsset extends AssetBundle
{


    public $sourcePath = '@year/editor/assets/FlexiJsonEditor';
    // public $basePath = '@webroot/assets';
    public $js = [
        'json2.js'
    ];
    public $css = [
        'jsoneditor.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        // Yii::setAlias('@leptureeditor', __DIR__);
        parent::init();

        if (YII_DEBUG === true) {
            $this->js[] =
                'jquery.jsoneditor.js';


        } else {
            $this->js[] = 'jquery.jsoneditor.min.js';

        }

    }


}