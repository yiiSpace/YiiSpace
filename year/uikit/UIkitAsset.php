<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/16
 * Time: 6:39
 */

namespace year\uikit;

use yii\web\AssetBundle;


class UIkitAsset extends AssetBundle
{
    public $depends = [
        'yii\web\YiiAsset',
    ];

    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/uikit';
    /**
     * @inheritdoc
     */
    public $css = [
       // 'css/uikit.min.css',
        'css/uikit.almost-flat.min.css',
       //  'components/flag.css'
    ];

    public $js = [
      'js/uikit.min.js',
    ];
}