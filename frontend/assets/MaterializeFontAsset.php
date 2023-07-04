<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 *  
 * 
 
 */
class MaterializeFontAsset extends AssetBundle
{
     /**
     * @inheritDoc
     */
    public $sourcePath = '@npm/material-icons';

    /**
     * @inheritDoc
     */
    public $css = [
        'iconfont/material-icons.css'
    ];
}
