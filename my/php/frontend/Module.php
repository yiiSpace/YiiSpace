<?php

namespace my\php\frontend;

/**
 * php module definition class
 */
class Module extends \yii\base\Module
{
    public $layout = 'php' ;
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'my\php\frontend\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
