<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/5/23
 * Time: 7:43
 */

namespace year\bootstrap;


use yii\web\AssetBundle;

/**
 * 需要经过bower安装 在composer 中安装（require配置段）： "bower-asset/twitter-bootstrap-wizard": "*"
 *
 * Class BootstrapWizardAsset
 * @package year\bootstrap
 */
class BootstrapWizardAsset extends AssetBundle
{

    public $sourcePath = '@bower/twitter-bootstrap-wizard';
    public $css = [
        'prettify.css',
    ];
    public $js = [

    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public function init()
    {
        /**
         * TODO bower 源好像不起作用
         */
        $this->sourcePath = __DIR__.'/assets/twitter-bootstrap-wizard';
        parent::init();

        if (YII_DEBUG) {
            $this->js = [
                'jquery.bootstrap.wizard.js'
            ];
        } else {
            $this->js = [
                'jquery.bootstrap.wizard.min.js'
            ];
        }
        $this->js[] = 'prettify.js';
    }

}