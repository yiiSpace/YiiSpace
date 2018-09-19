<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/4/5
 * Time: 8:17
 */

namespace my\uitest\frontend\assets;


use yii\web\AssetBundle;

class AppUiKit extends AssetBundle{

    public $css = [
       'main.css'
    ];
    public $js = [
    ];
    public $depends = [
       'year\uikit\UIkitAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/uikit';
        parent::init();
    }
}