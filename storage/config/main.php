<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
$config = [
    'id' => 'app-storage',
    'language'=>'zh-CN',
    'basePath' => __DIR__ . '/..',
    // 'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'urlManager' => [
            //'enableStrictParsing' => true,
            'enablePrettyUrl' => true,
            'showScriptName' => true,
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'cookieValidationKey' => getenv('COOKIE_VALIDATION_KEY'),
        ],
    ],
    'modules' => [

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
    /*
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
    */
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'],

    ];

}

return $config;
