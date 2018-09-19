<?php
/**
 * User: yiqing
 * Date: 2015/1/2
 * Time: 9:05
 */

namespace year\jsTpl;


use yii\web\AssetBundle;

class ArtTemplateAsset extends AssetBundle {

    /**
     * @var bool
     */
    public static $useNative = false ;

    public $sourcePath = '@year/jsTpl/assets/artTemplate/dist';

    public $depends = [
    ];

    public function init()
    {
        if(empty($this->js)){
            $this->js = [
                self::$useNative ? 'template-native.js':  'template.js',
            ];
        }
        parent::init() ;
    }
} 