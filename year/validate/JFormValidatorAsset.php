<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/1/24
 * Time: 23:46
 */

namespace year\validate;


use year\base\AssetBundle;

class JFormValidatorAsset extends AssetBundle{

    public $sourcePath = '@year/validate/assets/jQuery-Form-Validator/form-validator';

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
           YII_DEBUG ?'jquery.form-validator.js': 'jquery.form-validator.min.js',
        ];
        parent::init();
    }
}