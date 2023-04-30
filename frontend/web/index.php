<?php

require(__DIR__ . '/../../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../..');
//$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..'); // 这是线程安全版本
$dotenv->load();

//@see https://stackoverflow.com/questions/30881596/php-dotenv-unable-to-load-env-vars
//echo getenv('COOKIE_VALIDATION_KEY');
//print_r($_ENV); die(__FILE__);
// NOTE: 为了线程安全问题 dotenv库 不推荐使用getenv方法了 推荐的方法是$_ENV['DB_HOST'] 或者$_SERVER['XXX'] 如果还想使用需要用createUnsafeImmutable

if ($_ENV['YII_DEBUG'] === 'true') {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
} elseif ($_ENV['YII_DEBUG'] === 'false') {
    defined('YII_DEBUG') or define('YII_DEBUG', false);
}

if ($_ENV['YII_ENV'] !== false) {
    defined('YII_ENV') or define('YII_ENV', $_ENV['YII_ENV']);
}

require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../config/main.php')
);

(new yii\web\Application($config))->run();
