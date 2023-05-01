<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL) ;

require(__DIR__ . '/../../vendor/autoload.php');

// Dotenv::load(__DIR__ . '/../..');
//$dotenv = new Dotenv\Dotenv(__DIR__ . '/../..');
//$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../..');
$dotenv->load();

// todo: env 中的东西打印出来 不确定是不是加载了？

// print_r($_ENV); die(__FILE__);

if (getenv('YII_DEBUG') === 'true') {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
} elseif (getenv('YII_DEBUG') === 'false') {
    defined('YII_DEBUG') or define('YII_DEBUG', false);
}
// var_dump(getenv('YII_ENV')) ; die(__FILE__) ;
if (getenv('YII_ENV') !== false) {
    defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV'));
}

require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    // 本地的配置文件 可以排除到git提交中
    is_file(__DIR__ . '/../../common/config/main-local.php')? require(__DIR__ . '/../../common/config/main-local.php'):[],
    require(__DIR__ . '/../config/main.php'),
    // 本地的配置文件 可以排除到git提交中
    is_file(__DIR__ . '/../config/main-local.php')? require(__DIR__ . '/../config/main-local.php'):[]
);

// die(__FILE__);
(new backend\components\web\Application($config))->run();
