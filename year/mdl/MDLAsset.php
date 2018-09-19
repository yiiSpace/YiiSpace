<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/11/4
 * Time: 22:19
 */

namespace year\mdl;


use yii\web\AssetBundle;

/**
 * Class MDLAsset
 * @package year\mdl
 */
class MDLAsset extends AssetBundle
{

    public $sourcePath = '@bower/material-design-lite';
    /**
     * @var array

    public $css = [
        'material.css',
    ];
    public $js = [
        'material.js',
    ];
     *  */
    public function init()
    {
        parent::init();
        if(YII_DEBUG){
            $this->css = [
                'material.css',
            ];
            $this->js = [
                'material.js',
            ];
        }else{
            $this->css = [
                'material.min.css',
            ];
            $this->js = [
                'material.min.js',
            ];
        }
    }
}