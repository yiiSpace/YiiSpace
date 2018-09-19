<?php

namespace my\monkey;

/**
 * monkey module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'my\monkey\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here

        \Yii::setAlias('monkey',__DIR__);
        include_once (__DIR__.'/repl/repl.php');
    }
}
