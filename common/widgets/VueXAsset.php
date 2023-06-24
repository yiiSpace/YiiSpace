<?php

namespace common\widgets;

use yii\web\AssetBundle;

/**
 *
  @see  
  *
 *
 */
class VueXAsset extends AssetBundle
{
    public $sourcePath = null;
    public $js = [
        // 'https://unpkg.com/vue-router@4',
        // 'https://lib.baomitu.com/vuex/0.8.2/vuex.min.js',
        //  'https://cdn.jsdelivr.net/npm/vuex@3.0.1/dist/vuex.min.js',
        //  'https://cdn.bootcss.com/vuex/3.0.1/vuex.min.js',
         'https://cdn.bootcdn.net/ajax/libs/vuex/4.1.0/vuex.global.prod.min.js',
    ];
    public $depends = [
        VueAsset::class,
    ];
}
