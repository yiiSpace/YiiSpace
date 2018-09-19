<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/1/24
 * Time: 21:35
 */

namespace year\validate;


use year\base\AssetBundle;

class JValidateAsset extends AssetBundle{

    // public $sourcePath = '@yii/gii/assets';

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
        $this->sourcePath = __DIR__.'/assets/jquery-validation/dist';
        $this->js = [
          YII_DEBUG ? 'jquery.validate.js':'jquery.validate.min.js',
        ];
        parent::init();
    }
}