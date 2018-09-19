<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/5/15
 * Time: 16:40
 */

namespace year\widgets;


use yii\web\AssetBundle;

/**
 * 通过其实例获取baseUrl后 手工注册各种js 这是偷懒做法！
 *
 * Class BowerAsset
 * @package year\widgets
 */
class BowerAsset extends AssetBundle{

    public $sourcePath = '@bower' ;


}