<?php
require(__DIR__ . '/../../vendor/autoload.php');

// Dotenv::load(__DIR__ . '/../..');
$dotenv = new Dotenv\Dotenv(__DIR__ . '/../..');
$dotenv->load();

if (getenv('YII_DEBUG') === 'true') {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
} elseif (getenv('YII_DEBUG') === 'false') {
    defined('YII_DEBUG') or define('YII_DEBUG', false);
}

if (getenv('YII_ENV') !== false) {
    defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV'));
}


/*
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

*/

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');



$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);

$application = new \api\base\Application($config);
$application->run();
