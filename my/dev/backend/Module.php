<?php

namespace my\dev\backend;

class Module extends \yii\base\Module
{

    public $defaultRoute = 'module' ;

    public $controllerNamespace = 'my\dev\backend\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
