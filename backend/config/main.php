<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

$config = [
    'id' => 'app-backend',
    'basePath' => __DIR__ . '/..',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => [
        'log',
        'dbMan',
    ],
    'components' => [
        'dbMan'=>[
          'class'=>'backend\components\DbMan',
        ],
        'urlManager' => [
            //'enableStrictParsing' => true,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'view' => [
            'theme' => [
                'class' => 'year\base\Theme',
                'active' => 'easyui',
                'basePath' => '@backend/themes/bootstrap',
                // this will be used for assets(js css images) file
                'baseUrl' => '@web/themes/bootstrap',
                'pathMap' => [
                    '@app/views' => [
                        '@app/themes/bootstrap/views',
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
        'user' => [
            'identityClass' => 'backend\models\User',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'cookieValidationKey' => getenv('COOKIE_VALIDATION_KEY'),
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest', 'user'],
            'cache' => 'yii\caching\FileCache',
            'itemTable' => 'AuthItem',
            'itemChildTable' => 'AuthItemChild',
            'assignmentTable' => 'AuthAssignment',
            'ruleTable' => 'AuthRule',
        ],
    ],

    'modules' => [
        'treemanager' => [
            'class' => '\kartik\tree\Module',
            // other module settings, refer detailed documentation
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
        'news' => [
            'class' => 'my\news\backend\Module',
        ],
        'test' => [
            'class' => 'my\test\backend\Module',
        ],
        'migration' => [
            'class' => 'my\migration\backend\Module',
        ],
        /*
    'rbac0' => [
        'class' => 'yii2mod\rbac\Module',
        //Some controller property maybe need to change.
        'controllerMap' => [
            'assignment' => [
                'class' => 'yii2mod\rbac\controllers\AssignmentController',
               // 'userClassName' => 'backend\models\User',
                'userClassName' => 'my\admin\common\models\Admin',
            ]
        ]
    ],

    'rbac' => [
        'class' => 'dektrium\rbac\Module',
    ],
    */
        'admin' => [
            'class' => 'my\admin\backend\Module',
        ],
        'dev' => [
            'class' => 'my\dev\backend\Module',
        ],
        'devtools' => [
            'class' => 'my\devtools\backend\Module',
        ],
        'content' => [
            'class' => 'my\content\backend\Module',
        ],
        'plugins' => [
            'class' => 'lo\plugins\Module',
            'pluginsDir'=>[
                '@lo/plugins/core', // default dir with core plugins
                // '@common/plugins', // dir with our plugins
            ]
        ],
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
        'generators' => [
            'EasyUi-crud' => [
                'class' => 'backend\gii\crud\easyui\Generator',
                'templates' => [
                    'easy-ui' => '@backend/gii/crud/easyui/templates/default',
                    // 'easy-ui-yii' => Yii::getAlias('@backend/themes/easyui/_gii-yii-style/templates'),
                ]
            ],

            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [

                    'bs3-dolphin' => '@backend/gii/crud/bs3/backend-dolphin',
                ],
            ],

        ],
    ];

}

return $config;
