<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

$config = [
    'id' => 'app-frontend',
    'basePath' => __DIR__ . '/..',
    'controllerNamespace' => 'frontend\controllers',
    'bootstrap' => ['log'],
    // support the multiple themes
    'as themeAble' => [
        'class' => 'year\behaviors\Themable',
    ],
    'modules'=>[
        'uitest' => [
            'class' => 'my\uitest\frontend\Module',
        ],
        'test' => [
            'class' => 'my\test\frontend\Module',
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
        ],
        'user_x' => [
            'class' => 'my\user\frontend\Module',
        ],
    ],
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => false,
            // 'enableStrictParsing' => true,
            'showScriptName' => false,
            /*
             'enablePrettyUrl' => true,
             'showScriptName' => false,
             'enableStrictParsing' => true,
             */
            'rules' => [

                // '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                /*
               [

                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/country',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ]
                ]  */
            ],
        ] ,
        // @see http://www.ramirezcobos.com/2014/03/22/how-to-use-bootstrapinterface-yii2/
        'view' => [
            'theme' => [
                'class' => 'year\base\Theme',
                'active' => 'materialize',
                'basePath' => '@app/themes/materialize',
                // this will be used for assets(js css images) file
                'baseUrl' => '@web/themes/materialize',
                'pathMap' => [
                    '@app/views' => [
                        '@app/themes/materialize/views',
                    ]
                ],
                /*
                'pathMap' => [
                    '@app/views' => '@app/themes/basic',
                    '@app/modules' => '@app/themes/basic/modules', // <-- !!!
                ],
                */
            ],
        ],
        /*
        'user' => [
            'identityClass' => 'common\models\User',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        */
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
            // @TODO getenv 全部替换掉
            'cookieValidationKey' => getenv('COOKIE_VALIDATION_KEY'),
//            'cookieValidationKey' => 'yiqing-myvalidation-key-front',
        ],
        'session' => [
            'name' => '_frontendSessionId', // unique for frontend
             'savePath' => __DIR__ . '/../runtime', // a temporary folder on frontend
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
