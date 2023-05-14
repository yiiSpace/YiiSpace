<?php

namespace my\dev\backend\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionFillForm()
    {
        return $this->render('fill-form');
    }
}
