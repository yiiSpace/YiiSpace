<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 14-4-30
 * Time: 下午4:39
 */

namespace year\widgets;

use yii\web\View ;
use yii\base\Widget ;
use yii\web\AssetBundle ;

class JContextMenu extends Widget
{

    public function run()
    {
        JContextMenuAsset::register($this->getView());
    }
}

class JContextMenuAsset extends AssetBundle
{
    public $sourcePath = '@year/widgets/assets/contextMenu';

    public $js = [
        'src/jquery.ui.position.js',
        'src/jquery.contextMenu.js',
    ];

    public $css = [
        'src/jquery.contextMenu.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
}