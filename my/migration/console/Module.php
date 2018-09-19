<?php

namespace my\migration\console;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'my\migration\console\controllers';


    public $defaultRoute = 'db';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
