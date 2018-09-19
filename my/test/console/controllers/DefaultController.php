<?php

namespace my\test\console\controllers;


use Pheanstalk\Pheanstalk;
use yii\console\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $host = '192.168.118.7';
        // worker (performs jobs)
        $pheanstalk = new Pheanstalk($host);

        $running = true;
        do {
            echo ' waiting for the job coming !',PHP_EOL ;
            $job = $pheanstalk
                ->watch('testtube')
                ->ignore('default')
                ->reserve();

            $payload = $job->getData();

            if( strtolower($payload) == 'q'){
                $running = false ;
                echo 'client want stop the worker !' ;
            }else{
                echo 'payload :',$payload , PHP_EOL  ;
            }

            $pheanstalk->delete($job);

            $cache = \Yii::$app->cache;
            $key = 'stop';
            $stopFlag = $cache->get($key);
            if ($stopFlag) {
                $running = false;
                $cache->delete($key) ;
                echo 'delete the control flag ' ;
            }else{
                echo 'run the next job ', PHP_EOL;
            }

        } while ($running);

        echo 'exit the loop ';
    }


    public function actionStop()
    {
        $cache = \Yii::$app->cache;
        $cache->set('stop', true);

        echo 'success !';
    }

    /**
     * test beanstalk
     */
    public function actionBeanstalk()
    {

    }
}
