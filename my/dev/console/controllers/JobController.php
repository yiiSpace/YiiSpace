<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/9/12
 * Time: 20:28
 */

namespace my\dev\console\controllers;


use my\dev\console\jobs\DownloadJob;
use yii\console\Controller;
use yii\console\ExitCode;

class JobController extends Controller
{

    public function actionIndex()
    {
        $this->stdout(__METHOD__) ;
        return ExitCode::OK;
    }
    public function actionSend()
    {
        \Yii::$app->queue->push(new DownloadJob([
            'url' => 'http://example.com/image.jpg',
            'file' => '/tmp/image.jpg',
        ]));
        $this->stdout("Job send OK") ;
        return ExitCode::OK;
    }


}