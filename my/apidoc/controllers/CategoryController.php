<?php

namespace my\apidoc\controllers;

use yii\base\Module;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

use phpDocumentor\Reflection\FileReflector;
use yii\apidoc\models\ClassDoc;
use yii\helpers\StringHelper;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class CategoryController extends \yii\web\Controller
{

    //    public $layout = 'main' ;

    public function actionIndex()
    {

        // 扫描所有可能定义services的目录
        // TODO 目录从各个模块注册自己的api类所在的目录 推与拉是永恒的主题！
        $modules = \Yii::$app->getModules();

        $apiDirName = 'controllers'; // 其他项目中用的是 services

        $serviceDirs = [];
        foreach ($modules as $moduleId => $config) {
            $module = \Yii::$app->getModule($moduleId);

            // 忽略掉自身的
            if ($module->getUniqueId() === $this->module->getUniqueId()) {
                continue;
            }

            // 检测顶级模块的子模块们
            if (count($module->getModules()) > 0) {
                // 存在子模块了 递归收集
                $this->collectApiFilesOfSubModule($module, $serviceDirs, $apiDirName);
            } else {
                $modulePath = $module->getBasePath();
                $moduleServicesPath = $modulePath . DIRECTORY_SEPARATOR . $apiDirName;
                if (is_dir($moduleServicesPath)) {
                    $serviceDirs[] = $moduleServicesPath;
                }
            }
        }
        // 推入应用程序的的服务路径
        array_unshift($serviceDirs, \Yii::$app->getBasePath() . DIRECTORY_SEPARATOR . $apiDirName);

        // 找到所有的服务类文件
        // print_r($serviceDirs) ; die(__METHOD__) ;
        $servicePaths = [];
        foreach ($serviceDirs as $serviceDir) {
            $servicePaths = ArrayHelper::merge(
                $servicePaths,
                $this->findFiles($serviceDir, [
                    // 排除测试的服务类
//                'TestService.php'
                ])

            );
        }
        // $localIPs = ['127.0.0.1', '::1'];

        /**
         * ================================================================================================ begin \\
         */
        // 此处遍历所有服务类 并找出其简要描述跟描述 可以采用缓存

        // print_r($servicePaths) ; die(__METHOD__) ;

        $apiCategories = [];
        foreach ($servicePaths as $servicePath) {
            $fileName = $servicePath;

            //  $reflection = new FileReflector($fileName, true); // FIXME 第二个参数验证php文档的合法性
            $reflection = new FileReflector($fileName, false);

            $reflection->process();
            foreach ($reflection->getClasses() as $class) {
                try {
                    $class = new ClassDoc($class, null, ['sourceFile' => $fileName]);
                } catch (\Exception $ex) {
                    throw new ServerErrorHttpException(sprintf('文件%s 不规范doc生成有问题', $fileName));
                }

//                var_dump([$class]);
                // 忽略
                /// *'DocIgnore'
                if ($class->hasTag('docignore')) {
                    continue;
                }

                $apiCategories[] = [
                    'name' => $class->name,
                    'path' => $fileName,
                    'shortDescription' => $class->shortDescription,
                    'description' => $class->description,
                ];
                /*
                echo $class->shortDescription ,'<br/>' .$class->description ;
                $class->getPublicMethods() ;
                print_r($class->getPublicMethods());
                */
            }
            //   echo $fileName, '<br/>';
        }

        /**
         * ================================================================================================== end //
         */
        return $this->render('index', [
            'apiCategories' => $apiCategories,
        ]);
    }

    /**
     * @param Module $module
     * @param array $serviceDirs
     * @param string $apiDirName
     */
    protected function collectApiFilesOfSubModule(Module $module, array &$serviceDirs, $apiDirName)
    {
        $modulePath = $module->getBasePath();
        $moduleServicesPath = $modulePath . DIRECTORY_SEPARATOR . $apiDirName;
        if (is_dir($moduleServicesPath)) {
            $serviceDirs[] = $moduleServicesPath;
        }

        if (count($module->getModules()) > 0) foreach ($module->getModules() as $moduleId => $moduleConfig) {
            $subModule = $module->getModule($moduleId);
            // 递归  这里用了个技巧 没有写死方法 ： $this->collectApiFilesOfSubModule($subModule,$serviceDirs,$apiDirName) ;
            // 因为防止修改本方法 名称 那么所有引用到的地方都需要修改 让修改只发生在尽量少的地方！！！
            $myFunctionName = __FUNCTION__;
            // die($myFunctionName) ;
            $this->{$myFunctionName}($subModule, $serviceDirs, $apiDirName);

        }

    }


    /**
     * @inheritdoc
     */
    protected function findFiles($path, $except = [])
    {
        if (empty($except)) {
            $except = ['vendor/', 'tests/'];
        }
        $path = FileHelper::normalizePath($path);
        $options = [
            'filter' => function ($path) {
                if (is_file($path)) {
                    $file = basename($path);
                    if ($file[0] < 'A' || $file[0] > 'Z') {
                        return false;
                    }
                }

                return null;
            },
            'only' => ['*.php'], //['*Service.php'],
            'except' => $except,
        ];

        return FileHelper::findFiles($path, $options);
    }


    /**
     * 查看某个指定类的api详情
     *
     *  TODO 安全隐患 可能查看任意类的描述
     *
     * @param string $id
     */
    public function actionView($id = '')
    {
        $className = urldecode($id);
        $rc = new \ReflectionClass($className);
        //  TODO 可能不存在在文件哦  if()
        $fileName = $rc->getFileName();

        // 第二个参数 是开启严格验证的 会调用php命令行程序的
        // $reflection = new FileReflector($fileName, true);
        $reflection = new FileReflector($fileName, false);

        $reflection->process();

        $apiCategories = [];
        $apiList = [];
        /**
         * FIXME 这里不假设一个文件里面有多个类
         */
        foreach ($reflection->getClasses() as $class) {

            $class = new ClassDoc($class, null, ['sourceFile' => $fileName]);

//                var_dump([$class]);

            $apiCategories[$class->name] = [
                'name' => $class->name,
                'path' => $fileName,
                'shortDescription' => $class->shortDescription,
                'description' => $class->description,
            ];

            //  echo $class->shortDescription ,'<br/>' .$class->description ;
            $publicMethods = $class->getPublicMethods();
            // print_r($class->getPublicMethods());
            foreach ($publicMethods as $publicMethod) {

                // 非action 开头的动作会被忽略！！！
                if (!StringHelper::startsWith($publicMethod->name, 'action')) {
                    continue;
                }

                $apiList[] = [
                    // 'categoryName'=>$class->name ,
                    'categoryName' => $rc->getShortName(),
                    'name' => $publicMethod->name,
                    'shortDescription' => $publicMethod->shortDescription,
                    // 'methodInfo' => print_r($publicMethod,true)
                    'method' => $publicMethod
                ];
            }

        }

        return $this->render('view', [
            'apiCategories' => $apiCategories,
            'apiList' => $apiList,
        ]);
    }

    /**
     * @param $categoryId
     * @param string $methodName
     * @return string
     */
    public function actionApiItem($categoryId, $methodName = '')
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $className = urldecode($categoryId);

        $rc = new \ReflectionClass($className);
        //  TODO 可能不存在在文件哦  if()
        $fileName = $rc->getFileName();

        // $reflection = new FileReflector($fileName, true);
        $reflection = new FileReflector($fileName, false);

        $reflection->process();

        $apiCategories = [];
        $apiList = [];
        /**
         * FIXME 这里不假设一个文件里面有多个类
         */
        foreach ($reflection->getClasses() as $class) {

            $class = new ClassDoc($class, null, ['sourceFile' => $fileName]);

//                var_dump([$class]);

            $apiCategories[$class->name] = [
                'name' => $class->name,
                'path' => $fileName,
                'shortDescription' => $class->shortDescription,
                'description' => $class->description,
            ];

            $apiItem = [];
            if (isset($class->methods[$methodName])) {
                $apiItemMethod = $class->methods[$methodName];
                $apiItem = [
                    'categoryName' => $rc->getShortName(),
                    'name' => $apiItemMethod->name,
                    'shortDescription' => $apiItemMethod->shortDescription,
                    'methodInfo' => print_r($apiItemMethod, true)
                    // 'method'=>$apiItemMethod
                ];
                return $apiItem;
            } else {
                return false;
            }
            /*
            //  echo $class->shortDescription ,'<br/>' .$class->description ;
            $publicMethods = $class->getPublicMethods() ;
            // print_r($class->getPublicMethods());
            foreach($publicMethods as $publicMethod){
                $apiList[] = [
                    // 'categoryName'=>$class->name ,
                    'categoryName'=>$rc->getShortName() ,
                    'name' => $publicMethod->name ,
                    'shortDescription' => $publicMethod->shortDescription  ,
                    // 'methodInfo' => print_r($publicMethod,true)
                    'method'=>$publicMethod
                ]   ;
            }
            */

        }

    }

    /**
     * TODO 找出所有api文件 并检测其健康性
     *
     * @return string
     */
    public function actionCheckHealth()
    {
        return '';
    }
}
