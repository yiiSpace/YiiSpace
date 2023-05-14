<?php

namespace common\widgets;

use yii\web\AssetBundle;

/**
 * 此库貌似有直接用json数据填充表单的能力 表单数据转json
 *
 * 用例场景 比如用在填充搜索表单字段值上 yii中还算方便 在其他框架中 表单字段填充有点费事 此库可以帮忙！
 */
class FormDataJsonAsset extends   AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = __DIR__.'/assets/form-data-json/dist';

    /**
     * @var array
     */
    public $js = [
        'form-data-json.min.js'
    ];

    /**
     * @var array
     */
    public $css = [
//        'aoform.min.css',
    ];

    public $depends = [
//        'yii\web\JqueryAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];

}