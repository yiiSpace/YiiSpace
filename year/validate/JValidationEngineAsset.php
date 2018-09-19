<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/1/24
 * Time: 22:10
 */

namespace year\validate;


use year\base\AssetBundle;

class JValidationEngineAsset extends AssetBundle{

    public $sourcePath = '@year/validate/assets/jQuery-Validation-Engine';

    public $css = [
        'css/validationEngine.jquery.css',
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
            $this->js[] =   'js/jquery.validationEngine.js';
        }else{
            $this->js = [
                // TODO 这里注意国际化问题！ 默认注册的是中国的哦 ^-^
                'js/languages/jquery.validationEngine-zh_CN.js',
                'js/jquery.validationEngine.js',
            ];
        }
        parent::init();
    }
}