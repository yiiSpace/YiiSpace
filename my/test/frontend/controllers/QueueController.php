<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/8/3
 * Time: 10:33
 */

namespace my\test\frontend\controllers;


use Pheanstalk\Pheanstalk;
use yii\web\Controller;

class QueueController extends Controller
{
    /**
     * @return Pheanstalk
     */
    protected function getPheanstalk()
    {

        // $pheanstalk = new Pheanstalk('127.0.0.1');
        $host = '192.168.118.7';
        $pheanstalk = new Pheanstalk($host);

        return  $pheanstalk;
    }

    /**
     *
     */
    public function actionPheanstalk()
    {

        /*
        // $pheanstalk = new Pheanstalk('127.0.0.1');
        $host = '192.168.118.7';
        $pheanstalk = new Pheanstalk($host);
        */

        $pheanstalk = $this->getPheanstalk() ;

        // ----------------------------------------
// check server availability

        // true or false
        if ($pheanstalk->getConnection()->isServiceListening()) {
             echo 'service is running  !' ;
            // ----------------------------------------
// producer (queues jobs)

            $pheanstalk
                ->useTube('testtube')
                ->put("job payload goes here\n");

        }else{
            echo 'server is stop !' ;
        }

    }

    /**
     *
     */
    public function actionStop()
    {
        $pheanstalk = $this->getPheanstalk() ;

        // ----------------------------------------
// check server availability

        // true or false
        if ($pheanstalk->getConnection()->isServiceListening()) {
            echo 'service is running  !' ;
            // ----------------------------------------
// producer (queues jobs)

            $pheanstalk
                ->useTube('testtube')
                ->put("q");

            echo 'exit the queue worker ' ;
        }else{
            echo 'server is stop !' ;
        }

    }
}