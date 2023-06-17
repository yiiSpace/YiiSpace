<?php

namespace common\widgets;

use yii\web\AssetBundle;

/**
 *
 * 据说被用在了 vscode代码中

 * @todo:  有人搭配vue-router ｜ element-plus
 * 
 * 注意：Vue 为 600kb,vue3-sfc-loader 为 1.4mb。因此,以没有构建步骤为核心思想的应用程序意味着向客户端机器发送 2mb 的 javascript。
 * 这是它们的原始大小,压缩后的大小为 800kb,这仍然是相当多的
 * 
 * - vue3-sfc-loader 的原理是把 Vue CLI 開發階段用的 SFC 編譯程式搬到瀏覽器端( vue3-sfc-loader.js = Webpack( @vue/compiler-sfc + @babel ) )，因此 vue3-sfc.loader.js 高達 1.37MB，以當代 JavaScript 力求輕薄的標準有點肥大。
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
