<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/4/3
 * Time: 22:32
 */

namespace my\test\frontend\controllers;


use yii\web\Controller;

class IframeController extends Controller
{


    public function actionIndex()
    {
        return $this->render('index') ;
    }
    public function actionContent()
    {
        return $this->render('content') ;
    }
}