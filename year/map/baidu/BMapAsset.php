<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/27
 * Time: 14:12
 */

namespace year\map\baidu;


use yii\web\AssetBundle;

class BMapAsset extends AssetBundle{

    public $js = [
      'GPS.js'
    ];

    public function init()
    {
        $this->sourcePath = __DIR__.'/assets';
        parent::init() ;
    }
}