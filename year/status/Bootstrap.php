<?php
/**
 * User: yiqing
 * Date: 14-8-1
 * Time: 上午9:57
 */

namespace year\status;

use yii\web\GroupUrlRule;

class Bootstrap implements \yii\base\BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {


        if ($app instanceof \yii\console\Application) {

        } else {


            $configUrlRule = [
                'prefix' => 'status',
                'rules' => [
                    'space'=>'space/index'
                ]
            ];

            $app->get('urlManager')->rules[] = new GroupUrlRule($configUrlRule);


        }

        $app->get('i18n')->translations['status*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => __DIR__ . '/messages',
        ];
    }
} 