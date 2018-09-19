<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/6/5
 * Time: 0:09
 */

namespace my\test\frontend\controllers;


use yii\web\Controller;

class WebController extends Controller
{


    public function actionWebSql()
    {
        return $this->render('web-sql');
    }

    public function actionIndexedDb()
    {
        return $this->render('indexed-db');
    }
}