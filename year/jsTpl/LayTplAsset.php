<?php
/**
 * User: yiqing
 * Date: 2015/1/1
 * Time: 16:50
 */

namespace year\jsTpl;


use yii\web\AssetBundle;

class LayTplAsset extends AssetBundle
{

    public $sourcePath = '@year/jsTpl/assets/laytpl-v1.1/laytpl';
    public $js = [
        'laytpl.js',
    ];
    public $depends = [
    ];

} 