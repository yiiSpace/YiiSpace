<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 14-4-27
 * Time: 下午3:05
 */

namespace year\widgets;

use yii\base\Widget ;

class JsTree extends Widget{

    public function run(){
       JsTreeAsset::register( $this->getView()) ;
    }
} 