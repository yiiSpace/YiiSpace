<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/9/12
 * Time: 20:27
 */

namespace my\dev\console\jobs;

use yii\base\BaseObject;

class DownloadJob extends BaseObject implements \yii\queue\JobInterface
{
    public $url;
    public $file;

    public function execute($queue)
    {
        echo "exec it " ;
        file_put_contents($this->file, file_get_contents($this->url));
    }
}