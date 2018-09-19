<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 14-5-15
 * Time: 上午9:34
 */

namespace year\widgets;

use yii\web\View ;
use yii\widgets\InputWidget;

class UEditor extends InputWidget{

    public function run(){
        $view = $this->getView();
        // TODO 这里绑定死了Asset 可以暴露出去哦！
        $asset = UEditorAsset::register($view);
        $asset->jsOptions ['position'] = View::POS_HEAD;

        parent::run();
    }


}

class UEditorAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@year/widgets/assets/ueditor1_3_6';
    public $js = [
        'ueditor.config.js',
    ];
    public $css = [
    ];
    public $depends = [
       // 'yii\web\JqueryAsset',
    ];

    public function init(){
        parent::init();

        if(YII_DEBUG){
            $this->js[] = 'ueditor.all.js';
        }else{
            $this->js[] = 'ueditor.all.min.js';
        }

    }
}
