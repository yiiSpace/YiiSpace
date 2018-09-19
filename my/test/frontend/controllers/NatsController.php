<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/1
 * Time: 13:53
 */

namespace my\test\frontend\controllers;


use yii\web\Controller;

class NatsController extends Controller
{
   public function actionPing()
   {

       $connectionOptions = new \Nats\ConnectionOptions();
       $connectionOptions
           ->setHost('localhost')
           ->setPort(4222);
       echo "Server: nats://" . $connectionOptions->getHost() . ":" . $connectionOptions->getPort() . PHP_EOL;
       $c = new \Nats\Connection($connectionOptions);
       $c->connect();
       $c->ping();
   }

    public function actionConnectauth()
    {

        $connectionOptions = new \Nats\ConnectionOptions();
        $connectionOptions
            ->setHost('localhost')
            ->setPort(4222)
            ->setUser("foo")
            ->setPass("bar");
        $c = new \Nats\Connection($connectionOptions);
        $c->connect();
        $c->close();
    }

    public function actionConnect()
    {
        $connectionOptions = new \Nats\ConnectionOptions();
        $connectionOptions
            ->setHost('localhost')
            ->setPort(4222);
        $c = new \Nats\Connection($connectionOptions);
        $c->connect();
        $c->close();
    }


    public function actionPub()
    {
        $connectionOptions = new \Nats\ConnectionOptions();
        $connectionOptions
            ->setHost('localhost')
            ->setPort(4222);
        $c = new \Nats\Connection($connectionOptions);
        $c->connect();
        $c->reconnect();
        $c->publish("foo", "bar");
        $c->publish("foo", "bar");
        $c->publish("foo", "bar");
        $c->publish("foo", "bar");
        $c->publish("foo", "bar");
    }
}