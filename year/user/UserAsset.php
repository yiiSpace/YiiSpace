<?php
/**
 * User: yiqing
 * Date: 14-7-30
 * Time: 上午8:52
 */

namespace year\user;

use yii\web\AssetBundle;

class UserAsset extends AssetBundle
{
    public $theme = 'bootstrap';
    // public $sourcePath = '@yii/debug/assets';
    public $css = [
        'main.css',
    ];
    /*
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    */

    public function init(){
        $this->sourcePath =  __DIR__ . DIRECTORY_SEPARATOR .'assets';

        if($this->theme == 'bootstrap' ){
           $this->depends =  [
               'yii\web\YiiAsset',
               'yii\bootstrap\BootstrapAsset',
           ];
        }
        parent::init() ;
    }
}
