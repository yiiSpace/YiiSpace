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
        [
            'class'=>'year\gii\form\Bootstrap',   // gii的 form 代码生成
        ],
        [
            'class'=>'year\gii\gogen\Bootstrap',   // go 代码相关
        ],
        [
            'class'=>'year\gii\models\Bootstrap',   // gii的 model 代码生成
        ],
    ],
    'components' => [
        'dbMan'=>[
          'class'=>'backend\components\DbMan',
        ],
        'urlManager' => [
            //'enableStrictParsing' => true,
            // 'enablePrettyUrl' => true,
            // 'showScriptName' => false,
        ],
        'view' => [
            'theme' => [
                'class' => 'year\base\Theme',
                // 'active' => 'adminlte', // 'easyui',
                'active' => 'adminlte2', // 'easyui',
                'basePath' => '@backend/themes/adminlte2',
                // this will be used for assets(js css images) file
                'baseUrl' => '@web/themes/adminlte2',
                'pathMap' => [
                    '@app/views' => [
                        '@app/themes/adminlte2/views',
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
                    // 'levels' => ['error', 'warning', ],
                    'levels' => ['error', 'warning','trace','info'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            // 'cookieValidationKey' => getenv('COOKIE_VALIDATION_KEY'),
                'cookieValidationKey'=>'yiqing-myvalidation-key',
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
        'dci' => [
            'class' => 'my\dci\backend\Module',
        ],
    ],
    'params' => $params,
];

// if (YII_ENV_DEV) {
if (YII_ENV) {
   
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
            'service-crud' => [
                'class' => 'year\gii\service\Generator',
                'templates' => [
                ]
            ],


        ],
    ];

}

return $config;
