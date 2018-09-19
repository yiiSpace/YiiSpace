<?php
/**
 * User: yiqing
 * Date: 2014/11/21
 * Time: 16:24
 */

namespace year\base;


use yii\web\View;

class YearAsset  extends  \yii\web\AssetBundle
{
    public $sourcePath = '@year/assets';
    public $js = [
        'year.js',
    ];
    public $depends = [
       'yii\web\JqueryAsset',
    ];

    public $jsOptions = [
        'position'=>View::POS_END,
    ];
}