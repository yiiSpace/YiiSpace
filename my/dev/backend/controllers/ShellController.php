<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/9/13
 * Time: 19:47
 */

namespace my\dev\backend\controllers;


use yii\helpers\Html;
use yii\web\Application;
use yii\web\Controller;

class ShellController extends Controller
{

    public function actionHelp()
    {
        $rootDir = dirname(\Yii::getAlias('@app'));
        $content = <<<CONTENT
    root is : $rootDir
CONTENT;
        // ## 在Web 服务器环境 php://stdout 是被忽略的！
        // @see https://stackoverflow.com/questions/11318768/php-stdout-on-apache
        // fcgi doesn't have STDIN and STDOUT defined by default
        defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
        // defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));
        defined('STDOUT') or define('STDOUT', fopen('php://output', 'w'));

        /**
         *
        define('STDOUT', fopen('php://memory', 'w+'));
        define('STDERR', STDOUT);
        Yii::$app->runAction($route, $params);
        rewind(STDOUT);
        $output = stream_get_contents(STDOUT); //including whatever was written to STDERR as well
        fclose(STDOUT);
         */

        require($rootDir . '/console/config/bootstrap.php');

        $config = \yii\helpers\ArrayHelper::merge(
            require($rootDir . '/common/config/main.php'),
            require($rootDir . '/console/config/main.php')
        );


        $runner = new \tebazil\runner\ConsoleCommandRunner(  $config );
        // $runner->run('migrate');
        // $runner->run('migrate\create', ['insert_test_id','interactive'=>false]);
        $runner->run('migration/create',['queue' ,'interactive'=>false

        ]);
        $output = $runner->getOutput();
        $exitCode = $runner->getExitCode();

        //  return $this->renderContent($content.'<br/>'.$output);
        return $this->renderContent(($output));
    }

    public function actionMigration($table)
    {
        $rootDir = dirname(\Yii::getAlias('@app'));
        $content = <<<CONTENT
    root is : $rootDir
CONTENT;


        require($rootDir . '/console/config/bootstrap.php');

        $config = \yii\helpers\ArrayHelper::merge(
            require($rootDir . '/common/config/main.php'),
            require($rootDir . '/console/config/main.php')
        );

        // 重写 migrations 生成的位置
        /**
         *  'migration' => [
        'class' => 'bizley\migration\controllers\MigrationController',
        ],
         */
        $migrationPath = '@app/runtime/4migrations' ;
        $config['controllerMap']['migration']['migrationPath'] = $migrationPath;

        // @see https://github.com/tebazil/yii2-console-runner/issues/2
        define('STDOUT', fopen('php://memory', 'w+'));
        define('STDERR', STDOUT);

        // ------------------------------------------------------------------------------------------------ +|

        // Yii::$app->runAction($route, $params);

        $runner = new \tebazil\runner\ConsoleCommandRunner(  $config );
        // $runner->run('migrate');
        // $runner->run('migrate\create', ['insert_test_id','interactive'=>false]);
        $runner->run('migration/create',[$table ,'interactive'=>false

        ]);
        $output = $runner->getOutput();
        $exitCode = $runner->getExitCode();

        // ------------------------------------------------------------------------------------------------ +|

        rewind(STDOUT);
        $output = stream_get_contents(STDOUT); //including whatever was written to STDERR as well
        fclose(STDOUT);

        $migrationDirPath = \Yii::getAlias($migrationPath) ;
        // 捕获文件名
        $subject = $output;
        $pattern = "/m[\d]+[^\.]*\.php/";
        if( preg_match($pattern, $subject, $matches /* , PREG_OFFSET_CAPTURE */) ){
            //        preg_match($pattern, $subject, $matches , PREG_OFFSET_CAPTURE );
            // print_r($matches[0]);
            $migrationFile = $migrationDirPath.DIRECTORY_SEPARATOR.$matches[0] ;
            // die($migrationFile) ;
            if(file_exists($migrationFile)){
                $output = '<pre>'.Html::encode( file_get_contents($migrationFile)) .'</pre>';

                // 程序运行完毕即删除
                \Yii::$app->on(Application::EVENT_AFTER_ACTION,function ()use($migrationFile){
                    if(file_exists($migrationFile)){
                        usleep(1000) ;
                        unlink($migrationFile) ;
                    }
                });
            }
        }
   if( \Yii::$app->request->getIsAjax()){
            return  $output ; // $this->renderAjax() ;
   }
        //  return $this->renderContent($content.'<br/>'.$output);
        return $this->renderContent($output);
    }



}