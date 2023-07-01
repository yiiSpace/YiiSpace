<?php

namespace common\widgets;

use yii\web\AssetBundle;

/**
  * 国内有个cdn网站也经常用：https://www.bootcdn.cn/
 * 
 * npm的在这里： https://www.npmjs.com/package/vuelidate
 *
 *
 */
class VuelidateAsset extends AssetBundle
{
    public $sourcePath = null;
    public $js = [
        // '',
       // 根据文档是这三个文件：
    //        <!--  Vuelidate -->
    // <script src="https://cdn.jsdelivr.net/npm/vue-demi"></script>
    // <script src="https://cdn.jsdelivr.net/npm/@vuelidate/core"></script>
    // <script src="https://cdn.jsdelivr.net/npm/@vuelidate/validators"></script>

        // 'https://cdn.jsdelivr.net/npm/vue-demi@0.14.5/lib/index.iife.min.js',
        'https://unpkg.com/vue-demi',
        'https://unpkg.com/vuelidate',
    ];
    public $depends = [
        VueAsset::class,
    ];
}
