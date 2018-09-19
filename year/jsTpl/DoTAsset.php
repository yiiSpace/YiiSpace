<?php
/**
 * User: yiqing
 * Date: 2015/1/1
 * Time: 23:25
 */

namespace year\jsTpl;


use yii\web\AssetBundle;

class DoTAsset extends AssetBundle{
    public $sourcePath = '@year/jsTpl/assets/doT';
    public $js = [
        'doT.min.js',
    ];
    public $depends = [
    ];
}