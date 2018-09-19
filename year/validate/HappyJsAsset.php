<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/1/25
 * Time: 0:06
 */

namespace year\validate;


use year\base\AssetBundle;

class HappyJsAsset extends AssetBundle{
     public $sourcePath = '@year/validate/assets/Happy.js';

    public $css = [
        // 'main.css',
    ];
    public $js = [
        //  YII_DEBUG ? 'jquery.validate.js':'',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    public function init()
    {
        $this->js = [
            'happy.js',
            'happy.methods.js',
        ];
        parent::init();
    }
}