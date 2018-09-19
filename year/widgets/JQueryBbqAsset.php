<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-17
 * Time: 上午10:42
 */

namespace year\widgets;


use yii\web\AssetBundle ;
use yii\web\View ;

class JQueryBbqAsset extends AssetBundle
{
    public $sourcePath = '@year/widgets/assets/jquery-bbq';


    public $depends = [
        'yii\web\JqueryAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = [
        'position' => View::POS_END,
    ];


    public function init(){
        if(YII_DEBUG){
            $this->js = [
                'jquery.ba-bbq.js',
            ];

        }else{
            $this->js = [
                'jquery.ba-bbq.min.js',
            ];
        }
        parent::init();
    }
} 