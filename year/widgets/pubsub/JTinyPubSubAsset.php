<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/3/15
 * Time: 17:02
 */

namespace year\widgets\pubsub;


use yii\web\AssetBundle;

class JTinyPubSubAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@year/widgets/pubsub/assets/jquery-tiny-pubsub/dist';

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
                'ba-tiny-pubsub.js',
            ];

        }else{
            $this->js = [
                'ba-tiny-pubsub.min.js',
            ];
        }

        parent::init();
    }


}