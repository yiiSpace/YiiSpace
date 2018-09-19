<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 14-4-27
 * Time: 下午3:42
 */

namespace year\widgets;

use yii\base\Widget ;

class ZTree extends Widget{

    public function run(){
        ZTreeAsset::register($this->getView()) ;
    }
} 