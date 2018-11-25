<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/9/20
 * Time: 15:26
 */

namespace year\widgets\featherlight;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\View;

class FeatherlightGallery  extends Widget
{
    public $items = [];
    public $previewOptions = [];
    public $sectionOptions = [];
    public function init()
    {
        JFeatherlightGalleryAsset::register($this->view);
        $this->view->registerJs("$('section.flight-gallery a').featherlightGallery({previousIcon: '&#9664;', nextIcon: '&#9654;', galleryFadeIn: 100, galleryFadeOut: 300})", View::POS_READY);
    }
    public function run()
    {
        $innerHtml = [];
        foreach ($this->items as $item)
            $innerHtml[] = Html::a(Html::img($item['src'], $this->previewOptions), $item['url']);
        return Html::tag('section', implode('', $innerHtml), ArrayHelper::merge(['class' => 'flight-gallery'], $this->sectionOptions));
    }
}