<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/6/10
 * Time: 14:32
 */

namespace my\test\console\controllers;


use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ProcessBuilder;
use yii\console\Controller;

class ProcessController extends Controller
{

    public function actionGo()
    {
        // 重复使用 只是参数不同 可以考虑用builder 设置命令行参数 获取 process 然后 获取commandLine
        $builder = new ProcessBuilder([
            'yii','migration/create','user'
        ]);
        // $builder->setPrefix('/usr/bin/tar');
        // $builder->setPrefix('/usr/bin/tar');

// '/usr/bin/tar' '--list' '--file=archive.tar.gz'
//        echo $builder
//            // ->setArguments(array('--list', '--file=archive.tar.gz'))
//            //  ->setArguments(array('--list', '--file=archive.tar.gz'))
//            ->getProcess()
//            ->getCommandLine();
       $process =  $builder->getProcess();
       $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        echo $process->getOutput();

        // $builder = new ProcessBuilder();
        $builder->setArguments([
            'yii','migration/create','user'
        ]);
        $process = $builder->getProcess();
        echo  $process->getCommandLine() ;
        // 阻塞调用！
        $process->run() ;
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        echo $process->getOutput();
    }
}