<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/11/4
 * Time: 23:36
 */

namespace frontend\themes\materialize\assets;


use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
  //  public $basePath = '@frontend/themes/materialize/static';
  //    public $baseUrl = '@web';
    public $css = [
      //  'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
     //   'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        // 注意此行代码跟parent::init() 相对位置！
        $this->sourcePath = __DIR__.'/../static';
        parent::init();

        $this->css = [
           'css/style.css',
        ];

        $this->js = [
            'js/init.js'
        ];

    }
}