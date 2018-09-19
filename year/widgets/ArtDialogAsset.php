<?php
/**
 * User: yiqing
 * Date: 2015/1/3
 * Time: 15:23
 */

namespace year\widgets;


use yii\base\InvalidCallException;
use yii\web\AssetBundle;

class ArtDialogAsset extends AssetBundle{
    /**
     * @var string
     */
    public $sourcePath = '@year/widgets/assets/artDialog6.0.4/dist';

    /**
     * @var array
     */
    public $depends = [
         'yii\web\JqueryAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];

    /**
     * @var array
     */
    public $jsOptions = [
        //  'position' => View::POS_END,
    ];

    public $css = [
        'css/ui-dialog.css',
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
            'dialog-min.js',
        ];
        parent::init();
    }

    /**
     *
     */
    public function enableDialogPlus(){
        if(empty($this->js)){
            throw new InvalidCallException('the dialog[.min].js must be include first !');
        }
        //   $this->js[] = YII_DEBUG ?   'dialog-plus.js' :   'dialog-plus.min.js' ;
        $this->js[] = 'dialog-plus-min.js' ;
    }
} 