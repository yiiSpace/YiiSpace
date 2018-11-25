<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/9/20
 * Time: 15:27
 */

namespace year\widgets\featherlight;


use yii\helpers\Html;

class FeatherLight  extends \yii\base\Widget
{
    public $src;
    public $url;
    public $imageOptions;

    public function init()
    {
        JFeatherlightAsset::register($this->view);
    }

    public function run()
    {
        return Html::a(Html::img($this->src, $this->imageOptions), $this->url, [
            'data' => [
                'featherlight' => 'image',
            ]
        ]);
    }
}