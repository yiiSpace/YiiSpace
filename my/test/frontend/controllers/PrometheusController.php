<?php

namespace my\test\frontend\controllers;

use yii\web\Controller;

use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis;

class PrometheusController extends Controller
{
    public function actionIndex()
    {
        // Redis::setDefaultOptions(array('host' => 'master.redis.reg'));
        Redis::setDefaultOptions(array('host' => '127.0.0.1'));
        $adapter = new \Prometheus\Storage\Redis();
        $registry = new CollectorRegistry($adapter);

        $counter = $registry->registerCounter('test', 'some_counter', 'it increases', ['type']);
        $counter->incBy(1, ['blue']);  //将统计结果增加1


        $counter = $registry->getOrRegisterCounter('test', 'some_counter', 'it increases', ['type']);
        $counter->incBy(3, ['blue']);

        $gauge = $registry->getOrRegisterGauge('test', 'some_gauge', 'it sets', ['type']);
        $gauge->set(2.5, ['blue']);

        $histogram = $registry->getOrRegisterHistogram('test', 'some_histogram', 'it observes', ['type'], [0.1, 1, 2, 3.5, 4, 5, 6, 7, 8, 9]);
        $histogram->observe(3.5, ['blue']);

        return __METHOD__;
    }
}
