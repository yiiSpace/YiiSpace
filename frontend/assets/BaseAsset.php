<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 *  
 * 
 
 */
class BaseAsset extends AssetBundle
{
    public $basePath = '@frontend/assets/dist'; // '@webroot';
    // public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/utils'
    ];
    public $depends = [
         
    ];
}
