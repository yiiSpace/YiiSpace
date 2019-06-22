<?php
// FIXME getenv 在测试环境下无法使用  所以临时全部变换为硬编码

$config = [
    'language' => 'zh-CN',
    'vendorPath' => __DIR__ . '/../../vendor',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'bootstrap' => [
        // 'dbMan',
        'queue', // The component registers own console commands
        'year\gii\dva\Bootstrap',// gii的react前端代码生成
        /*
        [
            'class'=>'year\gii\form\Bootstrap',   // gii的 form 代码生成
        ],
        */
//        [
//
//            'class'=>'year\gii\goodmall\Bootstrap',   // gii的goodmall 代码生成
//            'giiBaseUrl'=>'http://localhost:1323'  //  此处配置是应用参数注入 可以在其他地方访问：  Yii::$app->params['goodmall.giiBaseUrl']
//        ],
        /*
        [
            'class' => 'year\gii\yunying\Bootstrap',   // gii的goodmall 代码生成
            'giiBaseUrl' => 'http://localhost:1323'  //  此处配置是应用参数注入 可以在其他地方访问：  Yii::$app->params['goodmall.giiBaseUrl']
        ],
        [
            'class' => 'year\gii\yunying4java\Bootstrap',   // gii的goodmall 代码生成
        ],
        */
        [
            'class' => 'year\gii\migration\Bootstrap',   // migration 代码生成
        ],
        [
            'class' => 'year\gii\nodetest\Bootstrap',   // 测试 代码生成
        ],
    ],
    'components' => [
        /*
        'dbMan'=>[
            'class'=>'backend\components\DbMan',
        ],
        */
        'uploadStorage' => [
            'class' => 'year\upload\local\UploadStorage', // UploadStorage::className() , //
            'baseDirName' => 'upload',
            // 'basePath'=> dirname( \Yii::$app->getBasePath() ).DIRECTORY_SEPARATOR .'storage/EvaThumber' ,
            'basePath' => dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'storage/EvaThumber',
//             'baseUrl'=>'http://127.0.0.1:86/storage/EvaThumber',
            //'baseUrl'=>'http://127.0.0.1:5000/YiiSpace/storage/EvaThumber',
            'baseUrl' => 'http://127.0.0.1:666/storage/EvaThumber',
            // 'baseUrl' => rtrim($params['thumber'],'/'),
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii_space', //getenv('DB_DSN'),
            'username' => 'root', // getenv('DB_USERNAME'),
//            'password' => '', // getenv('DB_PASSWORD'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8',
        ],
        'db2' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=cxtx_mall', //getenv('DB_DSN'),
            'username' => 'root', // getenv('DB_USERNAME'),
            'password' => '', // getenv('DB_PASSWORD'),
            'charset' => 'utf8',
            'tablePrefix' => '',
        ],
        // 测试用的db
        'sqliteDb' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlite:'.dirname(dirname(__DIR__)).'/data/tmpdb.db',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer0' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,// 这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',  // smtp host
                'username' => 'yiispace@163.com',
                //  'password' => '',
                'password' => 'jdjzalixfjbydxmz',
                'port' => '25',
                // 'encryption' => 'tls',
                'encryption' => 'ssl',

            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['yiqing_95@qq.com' => 'admin']
            ],
        ],

        'xunsearch' => [
            'class' => 'hightman\xunsearch\Connection',    // 此行必须
            //  'iniDirectory' => '@app/config',	// 搜索 ini 文件目录，默认：@vendor/hightman/xunsearch/app
            'iniDirectory' => '@common/config/xunsearch',
            'charset' => 'utf-8',    // 指定项目使用的默认编码，默认即时 utf-8，可不指定
        ],
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                [
                    'http_address' => '127.0.0.1:9200',

                ],
                // configure more hosts if you have a cluster
            ],
            // @see https://www.elastic.co/guide/en/x-pack/current/setting-up-authentication.html
            'auth' => ['username' => 'elastic', 'password' => 'changeme'],
        ],

        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // connection ID
            'tableName' => '{{%queue}}', // table
            'channel' => 'default', // queue channel
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries
        ],

        'fs'=>[
            'class' => 'creocoder\flysystem\LocalFilesystem',
            // 'path' => '@webroot/files',
            'path' => '@storage/web/uploads',
        ],
        'casbin' => require(__DIR__.'/casbin/casbin.php'),

    ],
];

if (YII_ENV_DEV) {
    // $config['components']['mailer']['userFileTransport'] = true;
}

if (YII_ENV_PROD) {
    $config['components']['db']['enableSchemaCache'] = true;
}

return $config;
