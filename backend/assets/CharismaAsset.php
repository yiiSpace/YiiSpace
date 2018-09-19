<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/11
 * Time: 16:44
 */

namespace backend\assets;


use year\base\AssetBundle;

class CharismaAsset extends AssetBundle{
    public $basePath = '@backend/assets/static/charisma';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}