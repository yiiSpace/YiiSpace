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
 *
 * @see https://github.com/mailru/FileAPI
 *
 * Class FileApiAsset
 * @package year\widgets
 */
class FileApiAsset extends AssetBundle{


    /**
     * @var string
     */
    public $sourcePath = '@year/widgets/assets/fileapi/dist';
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
            $this->sourcePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets/fileapi/dist';
        }

        if (empty($this->js)) {
            $this->js = $this->getJs();
        }
     return parent::init();
    }

} 