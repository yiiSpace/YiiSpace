<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/7/3
 * Time: 17:45
 */

namespace year\widgets\marquee;


use yii\web\AssetBundle;

class LiMarqueeAsset extends AssetBundle
{

    // public $sourcePath = '@bower/...';

    public $js = [
        'jquery.limarquee/js/jquery.liMarquee.js',
    ];
    public $css = [
        //  'jquery.limarquee/css/style.css',
        'jquery.limarquee/css/liMarquee.css',
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