<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    is_file(__DIR__ . '/../../common/config/params-local.php') ? require(__DIR__ . '/../../common/config/params-local.php'):[],
    require(__DIR__ . '/params.php'),
    is_file(__DIR__ . '/params-local.php' ) ? require(__DIR__ . '/params-local.php') :[]
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',

    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module',
            'modules' => [
              // TODO 配置不同的版本实现模块
            ],
        ],
        'content' => [
            'class' => 'my\content\api\Module',
        ] ,
        'apidoc' => [
            'class' => 'my\apidoc\Module',
        ] ,
        //other modules .....
        'oauth2' => [
            'class' => 'filsh\yii2\oauth2server\Module',
            'tokenParamName' => 'accessToken',
            'tokenAccessLifetime' => 3600 * 24,
            'storageMap' => [
                'user_credentials' => 'common\models\User',
            ],
            'grantTypes' => [
                'user_credentials' => [
                    'class' => 'OAuth2\GrantType\UserCredentials',
                ],
                'refresh_token' => [
                    'class' => 'OAuth2\GrantType\RefreshToken',
                    'always_issue_new_refresh_token' => true
                ]
            ]
        ]
    ],
    'components' => [
        'apiRunner' => [
            'class' => 'year\api\base\Runner',
            'hostModules'=>[
                /*
                'user.*'=>'user',
                // 以store开始的归于store模块
                'store.*'=>'store',
                'storeGoods.*'=>'store',
                */
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            // 'enableStrictParsing' => true,
           'showScriptName' => false,
           /*
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            */
            'rules' => [
                'api_x/<tableName:\w+>' => 'quick/test',
                'api_x/<tableName:\w+>/<id:\d*>' => 'quick/test',
                // NOTE api rpc 调用
                'v1/<method:\w+[\.\w+]+>' => 'v1/rpc/call',
                // '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                /*
               [

                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/country',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ]
                ]  */

                // 'POST oauth2/<action:\w+>' => 'oauth2/rest/<action>',
            ],
        ] ,
        'view' => [
            'theme' => [
                'class' => 'year\base\Theme',
                'active' => 'bootstrap',
                'basePath' => '@app/themes/bootstrap',
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

        'request' => [
            'cookieValidationKey' => 'anyRandomString' ,//getenv('COOKIE_VALIDATION_KEY'),
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],

        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                 /*
                  * 此处逻辑已经被移动到 yii\base\Application 中！
                  *
                $response = $event->sender;
                // @see http://www.yiiframework.com/doc-2.0/guide-rest-error-handling.html
               // if ($response->data !== null && Yii::$app->request->get('suppress_response_code')) {
                if ($response->data !== null) {
                    $response->data = [
                        'success' => $response->isSuccessful,
                        'data' => $response->data,
                    ];

                    $response->statusCode = 200;
                }
                 */
            },
        ],

    ],
    'params' => $params,
];



