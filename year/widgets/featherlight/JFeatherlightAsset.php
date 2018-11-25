<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/9/20
 * Time: 15:22
 */

namespace year\widgets\featherlight;


use yii\web\AssetBundle;

class JFeatherlightAsset extends AssetBundle
{

    // public $sourcePath = '@bower/featherlight/';

    public $js = [
        'release/featherlight.min.js',
    ];
    public $css = [
        'release/featherlight.min.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    public function init()
    {
        if(empty($this->sourcePath)){
            $this->sourcePath = __DIR__ . '/assets';
        }
        parent::init();
    }
}