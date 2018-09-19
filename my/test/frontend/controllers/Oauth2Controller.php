<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/7/25
 * Time: 16:53
 */

namespace my\test\frontend\controllers;


use yii\web\Controller;

class Oauth2Controller extends Controller
{

    public function actionIndex()
    {
        return $this->render('index') ;
    }

}