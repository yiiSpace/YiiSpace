<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/23
 * Time: 10:34
 */

namespace backend\components\web;


class Application extends \yii\web\Application{


    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        // do some global action-filter !
        return true;
    }
}