<?php

namespace common\components;

/**
 * @see https://github.com/yiisoft/yii2/issues/1764
 *
 * Class ConsoleAppHelper
 * @package app\components
 */
class ConsoleAppHelper
{


    // public static function runAction( $route, $params = [ ], $controllerNamespace = null )

    /**
     * NOTE: 注意此函数参数的名称不能是params ，会跟require的文件里面的key冲突 被洗掉 这个很诡异的事  后来验证了 碰到require之类用即时函数隔离下 js|JQuery就这样搞
     *
     * @param $route
     * @param $actionParams
     * @param callable|null $afterNewConsoleApp 这个方法执行时应用程序已经进行了 preinit init bootstrap调用了
     * @return int|\yii\console\Response|null
     * @throws \yii\base\InvalidConfigException
     */
//    public static function runAction( $route, $params = [ ], callable $afterNewConsoleApp = null )
    public static function runAction($route, $actionParams = [], callable $afterNewConsoleApp = null)
    {
        \Yii::warning(print_r($actionParams, true), 'consolex');
        $oldApp = \Yii::$app;

        // fcgi doesn't have STDIN and STDOUT defined by default
        defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
        defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));

        /** @noinspection PhpIncludeInspection */
//        $config = require( \Yii::getAlias( '@app/config/console.php' ) );
        // 这个bug困扰了一段时间呢
        $config = (function () {
            // 使用即时函数包裹 防止变量名污染
            return \yii\helpers\ArrayHelper::merge(
                require(\Yii::getAlias('@common/config/main.php')),
                require(\Yii::getAlias('@console/config/main.php'))
            );
        })();

        // NOTE: 通过阅读源码可以看到 在new 里调用构造函数 内部分别调用了应用程序对象的preInit 和 父类组件的init方法
        //  应用程序本身也有复写init方法会调用bootstrap方法 bootstrap方法会依次调用 预先配置的组件的bootstrap(app) 方法
        $consoleApp = new \yii\console\Application($config);


//        if (!is_null( $controllerNamespace )) {
//            $consoleApp->controllerNamespace = $controllerNamespace;
//        }

        try {

            if (!empty($afterNewConsoleApp)) {
                call_user_func($afterNewConsoleApp, $consoleApp);
            }
            // use current connection to DB
            \Yii::$app->set('db', $oldApp->db);

            ob_start();

//            $exitCode = $consoleApp->runAction(
//                $route,
//                array_merge( $params, [ 'interactive' => false ] )
//            );
            // FIXME 为啥会跟配置中的params 冲突 ！如果参数名称起为params 就会被配置文件重的覆盖掉！
//            $actionParams =   $params ; //func_get_arg( 1 ) ;
            \Yii::warning(print_r($actionParams, true), 'console');
            $exitCode = $consoleApp->runAction(
                $route,
                array_merge($actionParams, ['interactive' => false, 'color' => false])
            );

            $result = ob_get_clean();

            \Yii::debug($result, 'console');

        } catch (\Exception $e) {

            \Yii::warning($e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine(), 'console');

            $exitCode = 1;
        }

        \Yii::$app = $oldApp;

        return $exitCode;
    }
}