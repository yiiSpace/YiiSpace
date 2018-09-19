<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/1/24
 * Time: 23:15
 */

namespace year\validate;


use year\base\AssetBundle;

class JValidityAsset extends AssetBundle{

    public $sourcePath = '@year/validate/assets/validity/build';

    public $css = [
        'jquery.validity.css',
    ];
    public $js = [
        //  YII_DEBUG ? 'jquery.validate.js':'',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    public function init()
    {
        //  注意// \Yii::$container->set(JValidationEngineAsset::className(), ['css' => ["skins/{$this->skin}.css"]]);
        // 可以发生在init之前的！
        if(!empty($this->js)){
            /*
            print_r($this->js) ;
            die(__METHOD__);
            */
            // 这种状况出现在JValidationEngine中做国际化了
            $this->js[] =   'jquery.validity.js';
        }else{
            $this->js = [
                'jquery.validity.js',
            ];
        }
        parent::init();
    }
}