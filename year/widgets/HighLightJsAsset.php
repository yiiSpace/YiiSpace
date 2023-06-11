<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/5/15
 * Time: 16:34
 */

namespace year\widgets;


use year\base\AssetBundle;

/**
 * @see https://github.com/isagalaev/highlight.js
 * todo 可以使用bower 安装 写composer 里面  通过composer 代理安装就可以了 跟jquery一样的
 *
 * @see https://highlightjs.org/
 * 
 * Class HighLightJsAsset
 * @package year\widgets
 */
class HighLightJsAsset extends AssetBundle{

    public $sourcePath = '@year/widgets/assets/highlightjs';
    public $js = [
        'highlight.pack.js',
    ];

    public $css = [
      'styles/default.css'
    ];

}