<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 14-4-27
 * Time: 下午11:41
 */

namespace year\widgets;

use yii\web\AssetBundle ;
use yii\web\View ;

class JCropperAsset extends AssetBundle
{
    public $sourcePath = '@year/widgets/assets/cropper';


    public $depends = [
        'yii\web\JqueryAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];


    public function init(){
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

        parent::init();
    }
} 