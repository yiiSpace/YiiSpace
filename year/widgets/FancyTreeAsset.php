<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 14-4-27
 * Time: 上午11:22
 */

namespace year\widgets;

use yii\web\View ;
use yii\web\AssetBundle;

class FancyTreeAsset extends AssetBundle
{
    public static $skinMapping = [
      'awesome'=>'skin-awesome',
      'bootstrap'=>'skin-bootstrap',
    ];
    /**
     * control the current used skin
     *
     * @var string
     */
    public static $skin = 'bootstrap';

    public $sourcePath = '@year/widgets/assets/fancyTree';

    public $js = [
      // 'jquery.fancytree-all.min.js'
      'jquery.fancytree.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];

    public function init(){
        if(isset(static::$skinMapping[static::$skin])){
            $skinCssDir = static::$skinMapping[static::$skin] ;
        }else{
            $skinCssDir =  'skin-'.static::$skin ;
        }
        $this->css = [
            YII_DEBUG?  $skinCssDir.'/ui.fancytree.css' : $skinCssDir.'/ui.fancytree.min.css',
        ];
        parent::init() ;
    }
}
