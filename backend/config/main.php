<?php

// 注意 裸require 会导致变量名污染 可以使用即时函数  (function(){})() 限制变量名外溢

use backend\components\DbMan;
use my\devtools\backend\controllers\QuickController;
use yii\filters\Cors;

$params = array_merge(
    require (__DIR__ . '/../../common/config/params.php'),
    require (__DIR__ . '/params.php')
);

$config = [
    'id' => 'app-backend',
    'basePath' => __DIR__ . '/..',
    'controllerNamespace' => 'backend\controllers',
    'controllerMap' => [
        // FIXME: 仅开发环境可用哦😯
        // 访问路由： index.php?r=quick/test&table_name=msg
        'quick' => [
            'class' => QuickController::class,
            'db' => DbMan::getDbId('test'),
        ],
    ],
    /*
    'as cors' => [
        'class' => Cors::class,
        'cors' => [

            // restrict access to
            // 新版浏览器好像不允许 origins='*'
            // 'Origin' => ['http://www.myserver.com', 'https://www.myserver.com'],
            'Origin' => ['*'],
            // Allow only POST and PUT methods
            'Access-Control-Request-Method' => ['*'],
            // 'Access-Control-Request-Method' => ['POST', 'PUT'],
            // Allow only headers 'X-Wsse'
            'Access-Control-Request-Headers' => ['X-Wsse','Content-Type', 'Authorization'],
            // 'Access-Control-Request-Headers' => ['X-Wsse'],
            // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
            'Access-Control-Allow-Credentials' => true,
            // Allow OPTIONS caching
            // 'Access-Control-Max-Age' => 3600,
            // Allow the X-Pagination-Current-Page header to be exposed to the browser.
            // 'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],

        ],
    ],*/
    'bootstrap' => [
        'log',
        'dbMan',
        [
            'class' => 'year\gii\form\Bootstrap', // gii的 form 代码生成
        ],
//        [
//            'class'=>'year\gii\gogen\Bootstrap',   // go 代码相关
//        ],
//        [
//            'class'=>'year\gii\models\Bootstrap',   // gii的 model 代码生成
//        ],
    ],
    'components' => [
        'assetManager' => [
            'forceCopy' => YII_DEBUG,
            // 'appendTimestamp' => true,
        ],
        'dbMan' => [
            'class' => backend\components\DbMan::class,
        ],
        // 注意如果隐藏了index.php url会好看些 不然就这样：
        // http://yiispace.com:7086/index.php/x_api
        'urlManager' => [
            //'enableStrictParsing' => true,
            // 'enablePrettyUrl' => false,
            // 'showScriptName' => true,
            'rules' => [
                'x_api/<tableName:\w+>' => 'quick/test',
                'x_api/<tableName:\w+>/<id:\d*>' => 'quick/test',
            ],
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
                    ],
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
                    'levels' => ['error', 'warning', 'trace', 'info'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            // 'cookieValidationKey' => getenv('COOKIE_VALIDATION_KEY'),
            'cookieValidationKey' => 'yiqing-myvalidation-key',
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
//        'audit' =>[
////           'class' => 'bedezign\yii2\audit\Audit',
//            'class' => bedezign\yii2\audit\Audit::class,
//        ] ,
        'recipe' => [
            'class' => 'my\recipe\backend\Module',
        ],
        'treemanager' => [
            'class' => '\kartik\tree\Module',
            // other module settings, refer detailed documentation
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
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
            'pluginsDir' => [
                '@lo/plugins/core', // default dir with core plugins
                // '@common/plugins', // dir with our plugins
            ],
        ],
        'dci' => [
            'class' => 'my\dci\backend\Module',
        ],

        'audit' => [
            'class' => 'bedezign\yii2\audit\Audit',
            // the layout that should be applied for views within this module
//            'layout' => 'main',
            // Name of the component to use for database access
            'db' => 'db',
            // List of actions to track. '*' is allowed as the last character to use as wildcard
            'trackActions' => ['*'],
            // Actions to ignore. '*' is allowed as the last character to use as wildcard (eg 'debug/*')
            'ignoreActions' => ['audit/*', 'debug/*'],
            // Maximum age (in days) of the audit entries before they are truncated
            'maxAge' => 'debug',
            // IP address or list of IP addresses with access to the viewer, null for everyone (if the IP matches)
            'accessIps' => ['127.0.0.1', '192.168.*'],
            // Role or list of roles with access to the viewer, null for everyone (if the user matches)
            'accessRoles' => ['admin'],
            // User ID or list of user IDs with access to the viewer, null for everyone (if the role matches)
            'accessUsers' => [1, 2],
            // Compress extra data generated or just keep in text? For people who don't like binary data in the DB
            'compressData' => true,
            // The callback to use to convert a user id into an identifier (username, email, ...). Can also be html.
//            'userIdentifierCallback' => ['app\models\User', 'userIdentifierCallback'],
            // If the value is a simple string, it is the identifier of an internal to activate (with default settings)
            // If the entry is a '<key>' => '<string>|<array>' it is a new panel. It can optionally override a core panel or add a new one.
            'panels' => [
                'audit/request',
                'audit/error',
                'audit/trail',
//                'app/views' => [
////                    'class' => 'app\panels\ViewsPanel',
//                    // ...
//                ],
            ],
            'panelsMerge' => [
                // ... merge data (see below)
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
// if (YII_ENV) {

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
                ],
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
                ],
            ],

        ],
    ];

}

return $config;
