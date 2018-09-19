<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/7/28
 * Time: 17:34
 */

namespace my\test\console\controllers;


use yii\console\Controller;

class EnvController extends Controller
{

    public function actionIndex()
    {
        $osEnvPath = getenv('Path') ;
        $osEnvPathArr = explode(';',$osEnvPath) ;
        sort($osEnvPathArr) ;
        $this->stdout(print_r($osEnvPathArr,true)) ;
    }

}