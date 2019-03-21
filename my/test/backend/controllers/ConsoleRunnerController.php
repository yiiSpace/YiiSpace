<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/3/20
 * Time: 23:39
 */

namespace my\test\backend\controllers;


use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use vova07\console\ConsoleRunner;
use yii\web\Controller;

class ConsoleRunnerController extends Controller
{

    public function actionIndex()
    {


        return __METHOD__;
    }

    public function actionMigrate()
    {
        // 这个是使用控制台应用调用  需要控制台配置
        // $runner = new \tebazil\runner\ConsoleCommandRunner();


        $yiiPath = \Yii::getAlias('@app');
        $yiiPath = dirname($yiiPath) . DIRECTORY_SEPARATOR . 'yii';
//        exit($yiiPath) ;

        // 这个使用的是无输出的 哑 执行
        //  use vova07\console\ConsoleRunner;
        // $cr = new ConsoleRunner(['file' => '@my/path/to/yii']);
        /*
        $cr = new ConsoleRunner(['file' => $yiiPath]);
//        $cr->run('controller/action param1 param2 ...');
        $cr->run('hello/to yiqing');
        */
        // exit(getcwd() . 'hiiiii') ;

        $runtimeDir = \Yii::getAlias('@runtime/migrate') ;

//        $process = new Process(['yii', 'hello/to'], dirname($yiiPath));
        $process = new Process([
            'yii',
            'migration/create',
            'user',
            '--migrationPath=@runtime/temp',
        ],
            dirname($yiiPath));
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo 'hi:', $process->getOutput();
    }

}