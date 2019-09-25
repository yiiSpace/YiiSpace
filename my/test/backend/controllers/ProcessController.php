<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/9/13
 * Time: 15:53
 */

namespace my\test\backend\controllers;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

use yii\web\Controller;

class ProcessController extends Controller
{

    public function actionIndex()
    {

        $output = shell_exec('gii-helper -d acontent -t ac_config');
        echo "<pre>$output</pre>";

        die(__METHOD__) ;
//        $process = new Process(['gii-helper -d acontent -t ac_config']);
        $process = Process::fromShellCommandline('gii-helper -d acontent -t ac_config');
        echo $process->getCommandLine() ;


        $process->run();

// executes after the command finishes
//        if (!$process->isSuccessful()) {
//            throw new ProcessFailedException($process);
//        }
//
//        echo $process->getOutput();


        $str = [] ;
        foreach ($process as $type => $data) {
            if ($process::OUT === $type) {
                $str[] = ("\nRead from stdout: ".$data);
            } else { // $process::ERR === $type
                $str[] = ("\nRead from stderr: ".$data);
            }
        }
        return $this->renderContent(implode("",$str)) ;

    }

}