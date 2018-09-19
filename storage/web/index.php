<?php

require(__DIR__ . '/../../vendor/autoload.php');

Dotenv::load(__DIR__ . '/../..');

if (getenv('YII_DEBUG') === 'true') {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
} elseif (getenv('YII_DEBUG') === 'false') {
    defined('YII_DEBUG') or define('YII_DEBUG', false);
}

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

(new yii\web\Application($config))->run();
