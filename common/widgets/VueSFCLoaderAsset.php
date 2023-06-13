<?php

namespace common\widgets;

use yii\web\AssetBundle;

/**
 *
 * 据说被用在了 vscode代码中

 * @todo:  有人搭配vue-router ｜ element-plus
 *
 */
class VueSFCLoaderAsset extends AssetBundle
{
    public $sourcePath = '@npm/vue3-sfc-loader';
    public $js = [
        'dist/vue3-sfc-loader.js',
    ];
    public $depends = [
        VueAsset::class,
    ];
}
