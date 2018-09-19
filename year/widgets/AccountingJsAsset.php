<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/10/10
 * Time: 15:39
 */

namespace year\widgets;


use yii\web\AssetBundle;

/**
 * TODO 用于数学计算的js库
 *
 * Class AccountingJsAsset
 * @package year\widgets
 */
class AccountingJsAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@year/widgets/assets/accounting.js';

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
                'accounting.js',
            ];

        }else{
            $this->js = [
                'accounting.min.js',
            ];
        }

        parent::init();
    }


}