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
 * @see https://github.com/WICG/ResizeObserver/issues/3
 * @see https://github.com/que-etc/resize-observer-polyfill
 *
 * @see https://github.com/wnr/element-resize-detector
 *
 * Class ElementResizeDetectorAsset
 * @package year\widgets
 */
class ElementResizeDetectorAsset extends  AssetBundle{

    public $sourcePath = '@year/widgets/assets/element-resize-detector';
    public $js = [
        'element-resize-detector.min.js',
    ];
    public $depends = [
    ];
}