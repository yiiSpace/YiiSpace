<?php

namespace my\dev\backend\controllers;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use yii\base\Module;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\helpers\StringHelper;
use yii\web\Response;

/**
 * todo yii 目前有queue 了  可以利用队列机制  把要执行的任务推入队列 然后再命令行来监听队列并执行任务
 *
 * Class ModuleController
 * @package my\dev\backend\controllers
 */
class ModuleController extends \yii\web\Controller
{

    public function actionIndex()
    {

        // $modules = \Yii::$app->getModules(true) ;
        $modules = \Yii::$app->getModules(false);
        $giiCommands = array_map(function ($item) /* use($this) */ {
            return $this->getGiiCommand($item);
        }, array_keys($modules));

        $giiCommands = array_combine(
            array_keys($modules),
            $giiCommands
        );
        $modelsPaths = array_combine(
            array_keys($modules),
            array_map(function ($item) {
                try{
                    $item = \Yii::$app->getModule($item);
                    return $this->findModelsPathOf($item);
                }catch (\Exception $ex){
                    // 发生异常了 返回空
                    return [] ;
                }


            }, array_keys($modules))
        );

        return $this->render('index', [
            'modules' => $modules,
            'giiCommands' => $giiCommands,
            'modelsPaths' => $modelsPaths,
        ]);
    }

    protected function findModelsPathOf(Module $module)
    {
        $modulePath = $module->basePath;
        // TODO 模块的结构目前主流的有两种布局
        $targetDir = '';

        // 使用global 也可以找到
        if (is_dir($modulePath . DIRECTORY_SEPARATOR . 'models')) {
            $targetDir = $modulePath;
        } elseif (is_dir(dirname($modulePath) . DIRECTORY_SEPARATOR . 'common')) {
            $targetDir = dirname($modulePath) . DIRECTORY_SEPARATOR . 'common';
        } else {
            return [];
        }


        $files = FileHelper::findFiles(
            $targetDir /*.DIRECTORY_SEPARATOR.'models'*/,
            [
                'filter' => function ($path) {
                    if (is_dir($path)) {
                        return true;
                    }
                    return null;
                },
                'only' => ['models/*.php'],
                'recursive' => true, // false,
            ]
        );
        return $files;
    }

    protected function getGiiCommand($moduleId = 'test')
    {

        $modelNamespace = 'my\\' . $moduleId . '\common\models';
        $crudControllerNamespace = 'my\\' . $moduleId . '\backend\controllers';
        $crudSearchModelNamespace = 'my\\' . $moduleId . '\common\models\search';
        $crudViewPath = '@my/' . $moduleId . '/backend/views';
        $tables = 'token,user_data';

        $giiCmd = <<<GII_CMD
     giiant-batch/index ^
    --modelNamespace={$modelNamespace} ^
    --crudControllerNamespace={$crudControllerNamespace} ^
    --crudSearchModelNamespace={$crudSearchModelNamespace} ^
    --crudViewPath={$crudViewPath} ^
    --tables={$tables}

GII_CMD;
        $parts = explode('^', $giiCmd);
        // die(print_r($parts, true)) ;
        $giiCmd = implode(' ', $parts);
        return ($giiCmd);
    }

    public function actionProcess()
    {
        $giiCmd = <<<GII_CMD
    yii giiant-batch ^
    --modelNamespace=app\models ^
    --crudControllerNamespace=app\modules\crud\controllers ^
    --crudSearchModelNamespace=app\modules\crud\models\search ^
    --crudViewPath=@app/modules/crud/views ^
    --tables=actor,film,film_actor

GII_CMD;

        $modelNamespace = 'my\test\common\models';
        $crudControllerNamespace = 'my\test\backend\controllers';
        $crudSearchModelNamespace = 'my\test\common\models\search';
        $crudViewPath = '@my/test/backend/views';
        $tables = 'token,user_data';

        $giiCmd = <<<GII_CMD
     giiant-batch ^
    --modelNamespace={$modelNamespace} ^
    --crudControllerNamespace={$crudControllerNamespace} ^
    --crudSearchModelNamespace={$crudSearchModelNamespace} ^
    --crudViewPath={$crudViewPath} ^
    --tables={$tables}

GII_CMD;
        $parts = explode('^', $giiCmd);
        // die(print_r($parts, true)) ;
        $giiCmd = implode(' ', $parts);
        die($giiCmd);
        // $giiCmd = str_replace('^',' ' ,$giiCmd) ;
        // 进程测试
        // $process = new Process(' php ../../yii');
        $process = new Process(' php ../../yii ' . $giiCmd);

        //  $process->setTimeout(3600);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        print $process->getOutput();
    }

    /**
     * @param string $moduleId
     * @return array
     */
    public function actionTables4module($moduleId = '')
    {

        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request;
        $moduleId = $request->post('moduleId');

        $module = \Yii::$app->getModule($moduleId);
        $modelPaths = $this->findModelsPathOf($module);

        $tables4module = $modelNSArr = [];
        foreach ($modelPaths as $modelFilePath) {
            // get namespace in file
            $fileContent = file_get_contents($modelFilePath);
            $nameSpacePattern = "|namespace\s+((\w+\\\\)+\w+)\s*;|i"; // 坑爹的反斜杠 要四个\\\\ 才表示一个
            $matches = [];

            if (preg_match($nameSpacePattern, $fileContent, $matches)) {
                //
                $modelNS = $matches[1];
                $modelNSArr[] = $modelNS;
                $modelClassName = $modelNS . '\\' . StringHelper::basename($modelFilePath, '.php');
                if (is_subclass_of($modelClassName, ActiveRecord::className())) {
                    $tables4module[] = call_user_func([$modelClassName, 'tableName']);
                }
            }
        }
        if(count($tables4module)>0){
            $tables4module = array_unique($tables4module) ;
        }


        // ==================================================================================   \\
        /*
        $oldDeclaredClasses = get_declared_classes() ;
        foreach($modelPaths as $modelPath){
            include_once($modelPath) ;
        }
        $nowDeclaredClasses = get_declared_classes() ;

        return [
            'm'=>__METHOD__ ,
            'modelPaths'=> $modelPaths ,
            'classes'=>array_diff($nowDeclaredClasses,$oldDeclaredClasses) ,
            'NSArray'=>$modelNSArr ,
            'tables'=>$tables4module,
        ];*/
        // ==================================================================================   //
        return $tables4module;
    }
}
