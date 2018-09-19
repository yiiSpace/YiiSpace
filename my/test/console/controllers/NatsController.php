<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/1
 * Time: 13:58
 */

namespace my\test\console\controllers;


use yii\console\Controller;

class NatsController extends Controller
{

    public function actionSub()
    {

        $connectionOptions = new \Nats\ConnectionOptions();
        $connectionOptions
            ->setHost('localhost')
            ->setPort(4222);
        $c = new \Nats\Connection($connectionOptions);
        $c->connect();
        $callback = function ($payload) {
            printf("Data: %s\r\n", $payload);
        };
        $sid = $c->subscribe("foo", $callback);
        $c->wait(2);
        $c->unsubscribe($sid);
    }

    public function actionReq()
    {
        $connectionOptions = new \Nats\ConnectionOptions();
        $connectionOptions->setHost('localhost')->setPort(4222);
        $c = new \Nats\Connection($connectionOptions);
        $c->connect();
        $c->request(
            'sayhello',
            'Marty McFly',
            function ($response) {
                echo $response->getBody();
            }
        );
    }

    public function actionRes()
    {
        $connectionOptions = new \Nats\ConnectionOptions();
        $connectionOptions
            ->setHost('localhost')
            ->setPort(4222);
        $c = new \Nats\Connection($connectionOptions);
        $c->connect();
        $sid = $c->subscribe(
            "sayhello",
            function ($res) {
                $res->reply("Hello, " . $res->getBody() . " !!!". 'From '.__METHOD__);
            }
        );
        $c->wait(2);
        $c->unsubscribe($sid);
    }
}