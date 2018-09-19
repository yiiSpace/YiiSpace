<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 14-4-28
 * Time: 下午4:56
 */

namespace year\widgets;

use yii\helpers\Json;
use yii\web\View ;
use yii\base\Widget ;

class IFrameAutoHeight extends Widget
{

    /**
     * @var string
     */
    public $selector = 'iframe';

    /**
     * @var array
     */
    public $options = [];

    public function run()
    {
        IFrameAutoHeightAsset::register($this->getView());

       if($this->selector !== false){

           $jsOptions = empty($this->options) ? '' : Json::encode($this->options) ;

           $jsInit = <<<JS_INI
        jQuery("{$this->selector}").iframeAutoHeight({$jsOptions});
JS_INI;
         $this->getView()->registerJs($jsInit,View::POS_READY);
       }

    }
}

class IFrameAutoHeightAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@year/widgets/assets/iframeAutoHeight';

    public $js = [
        'jquery.browser.js',
        'jquery.iframe-auto-height.plugin.1.9.5.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = [
        'position' => View::POS_END,
    ];

}