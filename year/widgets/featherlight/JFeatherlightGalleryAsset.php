<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/9/20
 * Time: 15:20
 */

namespace year\widgets\featherlight;


use yii\web\AssetBundle;

class JFeatherlightGalleryAsset extends AssetBundle
{
    // public $sourcePath = '@bower/featherlight/';

    public $js = [
        'release/featherlight.gallery.min.js',
    ];
    public $css = [
        'release/featherlight.gallery.min.css',
    ];
    public $depends = [
        'year\widgets\featherlight\JFeatherlightAsset',
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