<?php

namespace my\js\frontend;

/**
 * js module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'my\js\frontend\controllers';

    // 使用php模块的布局 懒得写一些通用逻辑了直接复用
    public $layout = '@my/php/frontend/views/layouts/php' ;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
