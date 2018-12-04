<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/3/16
 * Time: 14:59
 */

namespace my\devtools\backend\controllers;


use yii\web\Controller;

class DbController extends Controller
{

    public function actionIndex()
    {
        $dbSchema = \Yii::$app->db->getSchema();

        return $this->render('index',[
            'dbSchema'=>$dbSchema,
        ]) ;
    }
}