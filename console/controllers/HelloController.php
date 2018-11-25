<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/11/25
 * Time: 10:04
 */

namespace console\controllers;


use yii\console\Controller;
use yii\console\Request;
use yii\helpers\Console;

class HelloController extends Controller
{
    public function actionTo($name='yiqing')
    {
        $this->stdout("hello {$name}.\n");
        return static::EXIT_CODE_NORMAL ;
    }

    /**
     * @param $cmd
     * @param $params
     * @return int
     * @throws \yii\console\Exception
     */
    public function actionCmd($cmd , $params )
    {
        /** @var Request $request */
        $request = \Yii::$app->request ;
        list ($route, $params ) =   $request->resolve() ;
        print_r(
            [
                'route'=>$route ,
                'params'=>$params
            ]
        ) ;
        return static::EXIT_CODE_NORMAL ;
    }
}