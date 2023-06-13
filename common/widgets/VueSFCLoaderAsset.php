<php

namespace common\widgets;

use yii\web\AssetBundle;

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