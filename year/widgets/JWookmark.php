<?php
/**
 * User: yiqing
 * Date: 14-8-22
 * Time: 下午12:36
 */

namespace year\widgets;

use yii\base\Widget ;

class JWookmark  extends Widget
{

    public function run()
    {
        print_r($this->getView());
         // die(__METHOD__ );
        JWookmarkAsset::register( $this->getView()) ;
    }
}