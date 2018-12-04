<?php

namespace my\devtools\backend;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'my\devtools\backend\controllers';

    public $defaultRoute = 'api/index' ;

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
