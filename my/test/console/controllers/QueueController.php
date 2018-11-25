<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/5/10
 * Time: 16:06
 */

namespace my\test\console\controllers;

use year\queue\CommandJob;
use Yii ;
use my\test\queue\HelloWorldJob;
use yii\console\Controller;

/**
 * Class QueueController
 * @package my\test\console\controllers
 */
class QueueController extends Controller
{

    /**
     * test push a job to queue
     */
    public function actionPush()
    {
        Yii::$app->queue->push(new HelloWorldJob([
            'to' => 'yiqing',
        ]));

        Yii::$app->queue->later(new HelloWorldJob([
            'to' => 'java',
        ]), 5 * 60);
    }

    /**
     * @TODO 允许从参数传入需要在队列中执行的命令 以及命令参数！
     *
     * test push a cmd job to queue
     */
    public function actionCmd()
    {
        Yii::$app->queue->push(new CommandJob([
            'cmd' => 'hello/to',
            'params'=>[
                'yiqing ya !'
            ]
        ]));

    }
}