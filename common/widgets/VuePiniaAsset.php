<?php

namespace common\widgets;

use yii\web\AssetBundle;

/**
 *
* @see https://github.com/vuejs/pinia

 * 如果有空 可以用 https://asset-packagist.org/package/npm-asset/pinia
 * 安装到本地也行
 * npm的在这里： https://www.npmjs.com/package/pinia
 *
 *
 */
class VuePiniaAsset extends AssetBundle
{
    public $sourcePath = null;
    public $js = [
        // '',
        'https://unpkg.com/pinia',
    ];
    public $depends = [
        VueAsset::class,
    ];
}
