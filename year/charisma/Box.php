<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/7/24
 * Time: 13:55
 */

namespace year\charisma;


use yii\bootstrap\Widget;
use yii\helpers\Html;

class Box extends Widget
{

    /**
     * @var string
     */
    public $headerTitle = '';

    /**
     * @var array
     */
    public $headerIcons = [];

    /**
     * @var string additional header options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @since 2.0.1
     */
    public $headerOptions;


    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->initOptions();
        echo Html::beginTag('div', $this->options) . "\n";
        echo Html::beginTag('div', ['class' => 'box-inner']) . "\n";
        echo $this->renderHeader() . "\n";

        echo $this->renderBoxContentBegin() . "\n";
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo "\n" . $this->renderBoxContentEnd();

        echo "\n" . Html::endTag('div'); // box-inner end
        echo "\n" . Html::endTag('div'); // box end

    }

    /**
     * Renders the header HTML markup of the modal
     * @return string the rendering result
     */
    protected function renderHeader()
    {

        Html::addCssClass($this->headerOptions, 'box-header well');
        // TODO add Original title ?
        $this->headerOptions['data-original-title'] = '' ;

        $headerIcons = is_array($this->headerIcons) ? implode("\n", $this->headerIcons) : $this->headerIcons;

        $headerContent = <<< HEADER
    <h2>{$this->headerTitle}</h2>
    <div class="box-icon">
        {$headerIcons}
    </div>
HEADER;
        return Html::tag('div', "\n" . $headerContent . "\n", $this->headerOptions);

    }

    /**
     * Renders the opening tag of the modal body.
     * @return string the rendering result
     */
    protected function renderBoxContentBegin()
    {
        return Html::beginTag('div', ['class' => 'box-content']);
    }

    /**
     * Renders the closing tag of the modal body.
     * @return string the rendering result
     */
    protected function renderBoxContentEnd()
    {
        return Html::endTag('div');
    }


    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions()
    {
        $this->options = array_merge([
            'class' => 'box',

        ], $this->options);
        Html::addCssClass($this->options, 'box');

    }
}