<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 14-4-27
 * Time: 下午3:06
 */

namespace year\widgets;

use yii\web\AssetBundle;

// use yii\web\JqueryAsset ;

/**
 * TODO 可以使用bower源 composer安装：https://github.com/vakata/jstree/blob/master/composer.json
 * 参考的扩展做法： https://github.com/dmstr/yii2-adminlte-asset
 *
 * Class JsTreeAsset
 * @package year\widgets
 */
class JsTreeAsset extends AssetBundle
{
    public $sourcePath = '@year/widgets/assets/jsTree';
    public $js = [
        'dist/jstree.min.js',
    ];
    public $css = [
        'dist/themes/default/style.min.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}