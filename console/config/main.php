<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

$config = [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        // FIXME 给队列扩展临时用下
        'migrate-queue' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => null,
            'migrationNamespaces' => [
                // ...
                'yii\queue\db\migrations',
            ],
        ],
        // NOTE 从表生迁移文件
        // generate Migration class for your database tables
        'migration' => [
            'class' => 'bizley\migration\controllers\MigrationController',
        ],
        // use another command id which allow us have different config for the same Command
        'migrate2' => [
            'class' => 'yii\console\controllers\MigrateController',
            // for custom migration template
            'templateFile' => '@app/views/layouts/migration.php'
        ]
    ],
    'bootstrap' => ['log'],
    'on beforeRequest' => function ($event) {
        // 纠正中文显示问题
        // echo php_uname();
        // echo PHP_OS . PHP_EOL;
        /* Some possible outputs:
        Linux localhost 2.4.21-0.13mdk #1 Fri Mar 14 15:08:06 EST 2003 i686
        Linux
        FreeBSD localhost 3.2-RELEASE #15: Mon Dec 17 08:46:02 GMT 2001
        FreeBSD
        Windows NT XN1 5.1 build 2600
        WINNT
        */
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // echo 'This is a server using Windows!';
            exec('chcp 65001');
        } else {
        }

    },
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'authManager' => [
            // 'class' => 'yii\rbac\PhpManager', // or use 'yii\rbac\DbManager'
            'class' => 'yii\rbac\DbManager'
        ]
    ],

    'modules' => [
        'dev' => [
            'class' => 'my\dev\console\Module',
        ],
        // 测试模块
        'test' => [
            'class' => 'my\test\console\Module',
        ],
        //
        'user' => [
            'class' => 'my\user\console\Module',
        ],
        'migration-util' => [
            'class' => 'my\migration\console\Module',
        ],

    ],

    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
