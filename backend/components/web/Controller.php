<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/23
 * Time: 14:11
 */

namespace backend\components\web;


class Controller extends \yii\web\Controller{

    public function beforeAction($action)
    {

        $actionId = $action->getUniqueId() ;
        $controller = $action->controller ;
        $controllerId = $controller->id ;
        if($controllerId !== 'site'){
            // 修改主布局
           // $controller->layout = '@backend/themes/easyui/views/layouts/iframe';
        }

       return parent::beforeAction($action);
    }

}