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

        $mysqli = newMysqliProxy(new \mysqli('localhost','root','','test'));
        // $mysqli->pre
    }



}

/**
 * @param $mysqli
 * @return MySqliProxy|\mysqli
 */
function newMysqliProxy($mysqli) {
    return new MySqliProxy($mysqli) ;
}

class MySqliProxy {


    /**
     * @var \mysqli
     */
    protected $mysqli = null ;

    public function __construct(\mysqli $mysqli)
    {

        $this->mysqli = $mysqli ;
    }

    public function __call($name, $arguments)
    {
        // 根据$name  做一些不可描述的事情  比如记录日志  偷偷修改sql语句之类
        return call_user_func_array([$this->mysqli,$name],$arguments) ;
    }

}