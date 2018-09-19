【吐槽】webees.net
<?php
//调试模式
define('YII_DEBUG', true);
//运行环境
define('YII_ENV', 'dev');

//载入系统引导
require __DIR__ . '/../../../sys/config/bootstrap.php';
//载入应用引导（可选）
//require __DIR__ . '/../config/bootstrap.php';

//载入配置文件
$config = yii\helpers\ArrayHelper::merge(
    //系统配置
    require (__SYS__ . '/config/main.php'),
    require (__SYS__ . '/config/main-local.php'),
    //应用配置
    require (__DIR__ . '/../config/web.php'),
    require (__DIR__ . '/../config/web-local.php')
);

//实例化并配置应用主体
$application = new yii\web\Application($config);

/**
 * 默认预定义路径别名：
 *
 * @yii 表示Yii框架所在的目录，也是 yii\BaseYii 类文件所在的位置；
 * @app 表示正在运行的应用的根目录，一般是 digpage.com/frontend ；
 * @vendor 表示Composer第三方库所在目录，一般是 @app/vendor 或 @app/../vendor ；
 * @bower 表示Bower第三方库所在目录，一般是 @vendor/bower ；
 * @npm 表示NPM第三方库所在目录，一般是 @vendor/npm ；
 * @runtime 表示正在运行的应用的运行时用于存放运行时文件的目录，一般是 @app/runtime ；
 * @webroot 表示正在运行的应用的入口文件 index.php 所在的目录，一般是 @app/web；
 * @web URL别名，表示当前应用的根URL，主要用于前端；
 * @common 表示通用文件夹；
 * @frontend 表示前台应用所在的文件夹；
 * @backend 表示后台应用所在的文件夹；
 * @console 表示命令行应用所在的文件夹；
 *
 */

//设置路径常量
//define('YII_PATH', Yii::getAlias('@yii')); //YII框架目录
//define('APP_PATH', Yii::getAlias('@app')); //当前应用程序的根路径
define('__WEB__', Yii::getAlias('@web')); //当前应用的根URL，主要用于前端

//运行
$application->run();
【吐槽】webees.net 2015/6/9 23:02:33
<?php

/**
 * IS_CGI 是否属于 CGI模式
 * IS_WIN 是否属于Windows 环境
 * IS_CLI 是否属于命令行模式
 */
define('IS_CGI', (0 === strpos(PHP_SAPI, 'cgi') || false !== strpos(PHP_SAPI, 'fcgi')) ? 1 : 0);
define('IS_WIN', strstr(PHP_OS, 'WIN') ? 1 : 0);
define('IS_CLI', PHP_SAPI == 'cli' ? 1 : 0);

//程序根目录
define('__ROOT__', dirname(dirname(__DIR__)));
//系统目录
define('__SYS__', __ROOT__ . '/sys');
//应用目录
define('__APP__', __ROOT__ . '/app');

//载入 Composer 自动加载器
require __SYS__ . '/vendor/autoload.php';

//载入 Yii 的类文件
require __SYS__ . '/vendor/yiisoft/yii2/Yii.php';