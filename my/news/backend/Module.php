<?php

namespace my\news\backend;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'my\news\backend\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
        \Yii::$app->db->tablePrefix = 'tbl_';
    }
}
