<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 14-4-27
 * Time: 上午11:06
 */

namespace year\widgets;

 use yii\base\Widget;
use yii\web\View ;

class FancyTree extends Widget{

    public function run(){
        FancyTreeAsset::register( $this->getView()) ;
    }
} 