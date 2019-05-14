<?php
/**
 * User: yiqing
 * Date: 2015/1/3
 * Time: 15:23
 */

namespace year\layui;


use yii\base\InvalidCallException;
use yii\web\AssetBundle;

class LayerAsset extends AssetBundle{
    /**
     * @var string
     */
    public $sourcePath = '@year/layui/assets/';

    /**
     * @var array
     */
    public $depends = [
        //  'yii\web\JqueryAsset',
    ];

    /**
     * @var array
     */
    public $jsOptions = [
        //  'position' => View::POS_END,
    ];

    public $css = [
    ];

    /**
     *
     */
    public function init(){
        /*
        if(YII_DEBUG){
            $this->js = [
                'dialog.js',
            ];

        }else{
            $this->js = [
                'dialog.min.js',
            ];
        }*/
        $this->js = [
            'layer/layer.js'
        ];
        parent::init();
    }


    public static function register($view)
    {
        static $flag  = false ;
        if($flag == false){
            $flag = true ;
            return parent::register($view);
        }
    }

    /**
     *
     */
    public function enableXxx(){
        if(empty($this->js)){
            throw new InvalidCallException('the dialog[.min].js must be include first !');
        }
        //   $this->js[] = YII_DEBUG ?   'dialog-plus.js' :   'dialog-plus.min.js' ;
        $this->js[] = 'xxx-min.js' ;
    }
} 