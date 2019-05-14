<?php

namespace my\test\frontend\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionServer()
    {
        print_r($_SERVER) ;
    }

}
