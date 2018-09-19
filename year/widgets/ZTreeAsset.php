<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 14-4-27
 * Time: 下午3:42
 */

namespace year\widgets;


use yii\web\AssetBundle ;
use yii\web\View ;

class ZTreeAsset extends AssetBundle
{

    public $sourcePath = '@year/widgets/assets/zTree';

    public $js = [
        // 'jquery.fancytree-all.min.js'
        'js/jquery.ztree.all-3.5.js'
    ];

    public $css = [
        'css/zTreeStyle/zTreeStyle.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];


}
