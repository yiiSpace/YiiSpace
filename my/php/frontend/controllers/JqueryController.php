<?php

namespace my\php\frontend\controllers;

use yii\web\Controller;

class JqueryController extends Controller
{
    public function actionIndex()
    {
//        return $this->renderContent(__METHOD__);
        return $this->render('index');
    }
    public function actionDform()
    {
//        return $this->renderContent(__METHOD__);
        return $this->render('dform');
    }

}