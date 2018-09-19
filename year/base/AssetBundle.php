<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2015/1/22
 * Time: 19:46
 */

namespace year\base;


class AssetBundle extends \yii\web\AssetBundle{

    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

} 