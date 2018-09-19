<?php

namespace home\feedback\frontend;

/**
 * feedback module definition class
 */
class Module extends \yii\base\Module
{

    // public $layout = '//blank' ;

    public $defaultRoute = 'entry';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'home\feedback\frontend\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
