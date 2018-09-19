<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/4/5
 * Time: 7:26
 */

namespace year\uikit\core;


use yii\helpers\Html;
use yii\widgets\LinkPager;

/**
 * TODO uk-pagination-previous  还有一些css没有加
 *
 * Class Pagination
 * @package year\uikit\core
 */
class Pagination extends LinkPager
{

    public $options = ['class' => 'uk-pagination'];

    /**
     * @var string the CSS class for the active (currently selected) page button.
     */
    public $activePageCssClass = 'uk-active';
    /**
     * @var string the CSS class for the disabled page buttons.
     */
    public $disabledPageCssClass = 'uk-disabled';


    public $prevPageCssClass = 'uk-pagination-previous';
    /**
     * @var string the CSS class for the "next" page button.
     */
    public $nextPageCssClass = 'uk-pagination-next';

    /**
     *
     * /**
     * Renders a page button.
     * You may override this method to customize the generation of page buttons.
     * @param string $label the text label for the button
     * @param integer $page the page number
     * @param string $class the CSS class for the page button.
     * @param boolean $disabled whether this page button is disabled
     * @param boolean $active whether this page button is active
     * @return string the rendering result
     */
    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = ['class' => $class === '' ? null : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
            return Html::tag('li', Html::tag('span', $label), $options);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);

            return Html::tag('li', Html::tag('span', $label), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        return Html::tag('li', Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }
}