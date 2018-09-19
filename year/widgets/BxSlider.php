<?php
/**
 * User: yiqing
 * Date: 2014/12/2
 * Time: 15:55
 */

namespace year\widgets;


use yii\base\InvalidParamException;
use yii\base\Widget;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

class BxSlider   extends Widget {

    /**
     * @var string
     */
    public $selector ;
    /**
     * @var array
     */
    public $options = [];

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init() ;

        if(empty($this->selector)){
            throw new InvalidConfigException(' you must specify the selector param ! ' );
        }

    }


    public function run()
    {

        $view = $this->getView();
         BxSliderAsset::register($view);
        $options = empty($this->options)? '' : Json::encode($this->options);

        $jsInit = <<<EOD
       jQuery('{$this->selector}').bxSlider({$options});
EOD;

        //$view->registerJs($jsInit,\yii\web\View::POS_READY,__CLASS__.$this->id);
        $view->registerJs($jsInit,\yii\web\View::POS_READY);
    }
}