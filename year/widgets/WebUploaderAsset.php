<?php
/**
 * User: yiqing
 * Date: 2014/12/1
 * Time: 20:50
 */

namespace year\widgets;

use Yii ;
use yii\web\AssetBundle;

class WebUploaderAsset extends  AssetBundle
{
    /**
     * @var array
     */
    protected static  $_instanceConfig = [];

    /**
     * you can use this method to config the instance
     *
     * @param array $instanceConfig
     * @return mixed
     */
    public static  function configInstance($instanceConfig=[])
    {
        static::$_instanceConfig = $instanceConfig ;
        // return static ;
        return self ;
    }

    /**
     * @var string
     */
    public $sourcePath = '@year/widgets/assets/webuploader-0.1.5';
   // public $basePath = '@webroot/assets';
    /**
     * @var array
     */
    public $publishOptions =       [
            'forceCopy' => YII_DEBUG,
        ];
    /**
     * @var array
     */
    public $css = [
        'webuploader.css',
    ];
    /**
     * @var array
     */
    public $js = [];
    /**
     * @var array
     */
    public $depends = [
       //  'yii\web\JqueryAsset',
    ];

    /**
     * @return array
     */
    private function getJs() {
        return [
            YII_DEBUG ? 'webuploader.js' : 'webuploader.min.js',
        ];
    }

    public function init() {
        if(empty($this->sourcePath)){
            $this->sourcePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets/webuploader-0.1.5';
        }

        if (empty($this->js)) {
            $this->js = $this->getJs();
        }
        if (!empty(static::$_instanceConfig)) {
            Yii::configure($this, static::$_instanceConfig);
        }
        return parent::init();
    }

}
