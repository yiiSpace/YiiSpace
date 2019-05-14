<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/5/10
 * Time: 15:26
 */

namespace year\widgets;


use year\base\AssetBundle;

/**
 *
 * @see https://github.com/wnr/element-resize-detector
 *
 * Class ElementResizeDetectorAsset
 * @package year\widgets
 */
class IframeResizerAsset extends  AssetBundle{

    public $sourcePath = '@year/widgets/assets/iframe-resizer';

    public $js = [
        'js/iframeResizer.min.js',
        'js/iframeResizer.contentWindow.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = [
        // 'position' => View::POS_HEAD,
    ];
}