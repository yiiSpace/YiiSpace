<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 14-4-28
 * Time: 下午3:23
 */

namespace year\widgets;

use yii\web\View ;
use yii\base\Widget ;
use yii\web\AssetBundle ;

class IFrameResizer extends Widget
{

    public function run()
    {
        /*
        $view = $this->getView() ;
        $am = $view->getAssetManager() ;

        $bundleKey = __NAMESPACE__.__CLASS__ ;

        $am->bundles[$bundleKey] = new AssetBundle([
            'sourcePath'=>'@year/widgets/assets/iframeResizer',
            'js'=>[
                'js/iframeResizer.min.js',
                'js/iframeResizer.contentWindow.min.js',
            ],
            'depends' => [
                'yii\web\JqueryAsset',
            ],
        ]);
        $view->registerAssetBundle($bundleKey);
        */
        IFrameResizerAsset::register($this->getView());
    }


}

class IFrameResizerAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@year/widgets/assets/iframeResizer';

    public $js = [
        'js/iframeResizer.min.js',
        'js/iframeResizer.contentWindow.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];


}