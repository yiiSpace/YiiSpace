<?php
/**
 * User: yiqing
 * Date: 2015/1/6
 * Time: 11:13
 */

namespace year\jsTpl;


use yii\web\AssetBundle;

class MustacheAsset extends AssetBundle {

    public $sourcePath = '@year/jsTpl/assets/mustache/dist';

    public $depends = [
    ];

    public function init()
    {
        $this->js = [
            'mustache.min.js',
        ];
        parent::init() ;
    }
}