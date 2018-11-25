<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/2/13
 * Time: 15:42
 */

namespace year\gii\common\widgets;


use yii\web\AssetBundle;
use yii\web\View;

class JFileTreeAsset extends AssetBundle{

    /**
     * @var string
     */
    // public $sourcePath =  '@year/widgets/assets/js-beautify/js/lib';
    /**
     * @var array
     */
    public $publishOptions =       [
        // 'forceCopy' => YII_DEBUG,
    ];
    /**
     * @var array
     */
    public $css = [
        'jqueryFileTree.css'
    ];
    /**
     * @var array
     */
    public $js = [
        // 加载顺序 和例子相同
        'jquery.easing.js',
        'jqueryFileTree.js',
    ];
    /**
     * @var array
     */
    public $depends = [
        //  'yii\web\JqueryAsset',
    ];



    public function init() {
        if(empty($this->sourcePath)){
            $this->sourcePath = __DIR__ .'/assets/jquery.fileTree-1.01' ;
        }
        parent::init();

    }

}