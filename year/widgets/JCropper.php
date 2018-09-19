<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 14-4-27
 * Time: 下午11:40
 */

namespace year\widgets;

use yii\base\Widget ;

class JCropper extends  Widget
{

    public function run()
    {
        parent::run() ;

        JCropperAsset::register($this->getView() ) ;
    }

} 