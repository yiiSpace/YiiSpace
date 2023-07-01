<?php

namespace common\api;

/**
 * 作为api 应用的基控制器 可以做一些通用处理
 */
class BaseController extends \yii\web\Controller
{
    public function __construct($id, $module, $config = [])
    {

        parent::__construct($id, $module, $config);
    }

    public function init()
    {
        parent::init();
        // 监听Yii::$app->response->on(yii\web\Response::EVENT_BEFORE_SEND, function($event))
    }
}
