<?php
/**
 * User: yiqing
 * Date: 2014/12/3
 * Time: 20:29
 */

namespace year\bui;

use yii\web\AssetBundle;

class BuiAsset extends AssetBundle
{
    public $sourcePath = '@year/bui/assets';
    public $css = [
        'css/bs3/dpl-min.css',
        'css/bs3/bui-min.css',
    ];
}
