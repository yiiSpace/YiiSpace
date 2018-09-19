<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/5/10
 * Time: 16:07
 */

namespace my\test\queue;


use yii\base\Object;

class HelloWorldJob extends Object implements \zhuravljov\yii\queue\Job
{
    public $to;

    public function execute($queue)
    {
        // file_put_contents($this->file, file_get_contents($this->url));
        // var_dump($queue);

        echo " hello {$this->to}";
    }
}