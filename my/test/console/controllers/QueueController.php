<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/5/10
 * Time: 16:06
 */

namespace my\test\console\controllers;

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

}