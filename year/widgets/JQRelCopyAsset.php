<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/1/23
 * Time: 6:57
 */

namespace year\widgets;


use yii\web\AssetBundle;

class JQRelCopyAsset extends AssetBundle{

    /**
     * @var string
     */
    public $sourcePath = '@year/widgets/assets/jqrelcopy/assets/js';
    // public $basePath = '@webroot/assets';
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

    ];
    /**
     * @var array
     */
    public $js = [];
    /**
     * @var array
     */
    public $depends = [
        //  'yii\web\JqueryAsset',
    ];

    /**
     * @return array
     */
    private function getJs() {
        return [
            'jquery.relcopy.yii2.js'
            // YII_DEBUG ? 'FileAPI.js' : 'FileAPI.min.js',
        ];
    }

    public function init() {
        if(empty($this->sourcePath)){
           // $this->sourcePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets/jquery.fileapi/dist';
        }

        if (empty($this->js)) {
            $this->js = $this->getJs();
        }
        return parent::init();
    }

}