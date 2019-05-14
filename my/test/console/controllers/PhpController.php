<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/4/11
 * Time: 18:15
 */

namespace my\test\console\controllers;


use yii\console\Controller;

class PhpController extends Controller
{

    public function actionArray()
    {
        $m1 = memory_get_usage() ;

        $test = [];
        for ($i=200000; $i >= 0; $i--) {
            $test[$i] = $i;
        }
        $m2 = memory_get_usage() ;
        $this->stdout($m2 - $m1) ;
    }
    public function actionArray2()
    {
        $m1 = memory_get_usage() ;
        $test = [];
        for ($i=0; $i < 200000; $i++) {
            $test[$i] = $i;
        }
        $m2 = memory_get_usage() ;
        $this->stdout($m2 - $m1) ;
    }

}