<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/7
 * Time: 11:33
 */

namespace year\widgets;

use yii\web\AssetBundle;

/**
 * @see https://github.com/domchristie/to-markdown
 *
 *
 * TODO 可以bower安装吆！
 *
 * Class ToMarkDownAsset
 * @package year\widgets
 */
class ToMarkDownAsset extends AssetBundle{


    /**
     * @var string
     */
    public $sourcePath = '@year/widgets/assets/to-markdown/dist';

    /**
     * @var array
     */
    public $js = [
        'to-markdown.js',
    ];


    /**
     * @var array
     */
    public $jsOptions = [
        //  'position' => View::POS_END,
    ];


}