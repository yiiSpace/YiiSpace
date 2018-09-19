<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/1
 * Time: 16:29
 */

namespace year\widgets;


use yii\web\AssetBundle;

class JsBeautifyAsset extends AssetBundle{

    /**
     * @var string
     */
    public $sourcePath = '@year/widgets/assets/js-beautify/js/lib';
    // public $basePath = '@webroot/assets';
    /**
     * @var array
     */
    public $publishOptions =       [
        // 'forceCopy' => YII_DEBUG,
    ];
    /**
     * @var array
     */
    public $css = [

    ];
    /**
     * @var array
     */
    public $js = [
        'beautify.js',
        'beautify-css.js',
        'beautify-html.js',
    ];
    /**
     * @var array
     */
    public $depends = [
        //  'yii\web\JqueryAsset',
    ];



    public function init() {
         parent::init();

    }

}