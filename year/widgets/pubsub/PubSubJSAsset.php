<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/3/15
 * Time: 17:07
 */

namespace year\widgets\pubsub;


use yii\web\AssetBundle;

class PubSubJSAsset  extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@year/widgets/pubsub/assets/PubSubJS-1.7.0/src';

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
        if(YII_DEBUG){
            $this->js = [
                'pubsub.js',
            ];

        }else{
            $this->js = [
                'pubsub.js',
            ];
        }

        parent::init();
    }


}