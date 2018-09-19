<?php
/**
 * User: yiqing
 * Date: 14-9-17
 * Time: 上午10:17
 */

namespace year\widgets;

use yii\web\AssetBundle ;
// use year\base\AssetBundle;
use yii\web\View;


class ExSelectAsset  extends AssetBundle
{
    public $sourcePath = '@year/widgets/assets/exSelect';


    public $depends = [
        'yii\web\JqueryAsset',
        // 'yii\bootstrap\BootstrapAsset',
        'year\widgets\JQueryBbqAsset',
    ];

    public $jsOptions = [
        'position' => View::POS_END,
    ];

    public $js = [
        'jquery.exSelect.js',
    ];

    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

    public function init(){
       /*
        if(YII_DEBUG){
            $this->js = [
                'cropper.min.js',
            ];
            $this->css = [
                'cropper.min.css',
            ];
        }else{
            $this->js = [
                'cropper.js',
            ];
            $this->css = [
                'cropper.css',
            ];
        }
       */

        parent::init();
    }
} 