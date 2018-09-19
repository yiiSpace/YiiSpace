<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-1-6
 * Time: 下午1:09
 */

namespace year\widgets;


use yii\web\AssetBundle;

class SortableAsset extends AssetBundle{
    /**
     * @var string
     */
    public $sourcePath = '@year/widgets/assets/Sortable/dist';

    /**
     * @var array
     */
    public $depends = [

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
        if(YII_DEBUG){
            $this->js = [
                'Sortable.js',
            ];

        }else{
            $this->js = [
                'Sortable.min.js',
            ];
        }

        parent::init();
    }
} 