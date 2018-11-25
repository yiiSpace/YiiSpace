<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/10/23
 * Time: 9:48
 */

namespace my\content\bundles;


use yii\web\AssetBundle;

/**
 * Class MyImageManagerAsset
 * @package my\content\bundles
 */
class MyImageManagerAsset extends AssetBundle
{
    /**
     * NOTE 此选项开发期可以确保js文件修改后的效果立刻呈现 不然就需要删除assets缓存
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
    /**
     * @inheritdoc
     */
    public $sourcePath = '@my/content/assets';
    /**
     * @inheritdoc
     */
    public $js = [
        // 'js/redactor-my-image.js',
        'js/imagemanager.js',
//        'js/iframe.js',
//        'js/advanced.js',
    ];
}