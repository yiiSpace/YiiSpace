<?php

namespace common\widgets;

use yii\web\AssetBundle;

/**
 *
  @see  
  *
 *
 */
class NaiveUiAsset extends AssetBundle
{
    public $sourcePath = null;
    public $js = [
        /**
         * 如果你要使用 minify 版本的包，将 https://unpkg.com/naive-ui@version/dist/index.prod.js 作为 src，version 是你期望使用的版本，如果不指定 version 则会使用最新的版本。

            你最好锁定包的版本，不然可能会有不兼容变更
            如：https://unpkg.com/naive-ui@2.34.4/dist/index.prod.js

            目前 UMD 版本的 naive 标签自闭合存在问题。请显式进行标签闭合。如：<n-input></n-input>。
         */
        //  'https://unpkg.com/naive-ui@version/dist/index.prod.js ',
        //  'https://unpkg.com/naive-ui/dist/index.prod.js ', // 这个是可用链接 应该和下面👇链接等价吧？
         'https://unpkg.com/naive-ui',
    ];
    public $depends = [
        VueAsset::class,
    ];
}
