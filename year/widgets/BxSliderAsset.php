<?php
/**
 * User: yiqing
 * Date: 2014/12/2
 * Time: 15:43
 */

namespace year\widgets;

use yii\web\View ;
use yii\web\AssetBundle;

class BxSliderAsset  extends AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = '@year/widgets/assets/jquery.bxslider';

    /**
     * @var array
     */
    public $js = [
        // 'jquery.fancytree-all.min.js'
        'jquery.bxslider.min.js',
    ];

    /**
     * @var array
     */
    public $css = [
        'jquery.bxslider.css',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];

    /**
     * @var array
     */
    public $jsOptions = [
      //  'position' => View::POS_END,
    ];


}