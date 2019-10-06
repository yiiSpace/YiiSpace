<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/10/6
 * Time: 9:32
 */

namespace my\test\backend\controllers;


use yii\web\Controller;

class SqlController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index',[

        ]);
    }

}