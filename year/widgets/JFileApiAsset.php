<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-1-6
 * Time: 下午1:25
 */

namespace year\widgets;
use yii\web\AssetBundle;

/**
 * TODO 暂时未封装 有空了做 这个东东很强大好像！
 *
 * @see http://rubaxa.github.io/jquery.fileapi/
 *
 * Class JFileApiAsset
 * @package year\widgets
 */
class JFileApiAsset extends AssetBundle{


    /**
     * @var string
     */
    public $sourcePath = '@year/widgets/assets/jquery.fileapi/dist';
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
            'FileAPI.min.js'
            // YII_DEBUG ? 'FileAPI.js' : 'FileAPI.min.js',
        ];
    }

    public function init() {
        if(empty($this->sourcePath)){
            $this->sourcePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets/jquery.fileapi/dist';
        }

        if (empty($this->js)) {
            $this->js = $this->getJs();
        }
     return parent::init();
    }

} 