<?php

namespace common\widgets;

use yii\web\AssetBundle;

/**
 *
  @see https://github.com/vuejs/router
  *
 * @todo:  有人搭配vue-router ｜ element-plus
 *
 */
class VueRouterAsset extends AssetBundle
{
    public $sourcePath = null;
    public $js = [
        'https://unpkg.com/vue-router@4',
    ];
    public $depends = [
        VueAsset::class,
    ];
}
