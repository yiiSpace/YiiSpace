<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

$config = [
    'id' => 'app-installer',
    'basePath' => __DIR__ . '/..',
    'controllerNamespace' => 'installer\controllers',
    'bootstrap' => ['log'],

    'modules'=>[

    ],
    'components' => [

        // @see http://www.ramirezcobos.com/2014/03/22/how-to-use-bootstrapinterface-yii2/
        'view' => [

        ],

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        /*
        'errorHandler' => [
            'errorAction' => ['/site/error'],
        ],
        */
        'request' => [
            'cookieValidationKey' => getenv('COOKIE_VALIDATION_KEY'),
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
