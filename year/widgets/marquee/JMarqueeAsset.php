<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/7/3
 * Time: 17:36
 */

namespace year\widgets\marquee;


use yii\web\AssetBundle;

/**
 * Class JMarquee
 * @package year\widgets\marquee
 */
class JMarqueeAsset extends AssetBundle
{

    // public $sourcePath = '@bower/...';

    public $js = [
        'jQuery.Marquee/jquery.marquee.js',
    ];
    public $css = [
//        'release/featherlight.min.css',
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