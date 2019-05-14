<?php

namespace year\gii\goodmall;

use year\gii\goodmall\generators\model\Generator;
use yii\base\Application;
use yii\base\BootstrapInterface;

/**
 * Class Bootstrap.
 *
 * @author yiqing <yiqing_95@qq.com>
 */
class Bootstrap implements BootstrapInterface
{

    /**
     * goodmall 中gii的基
     *
     * @var string
     */
    public $apiBaseUrl = '' ;

    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        if ($app->hasModule('gii')) {
            if (!isset($app->getModule('gii')->generators['giiant-goodmall-pod'])) {
                $app->getModule('gii')->generators['gii-goodmall-pod'] = 'year\gii\goodmall\generators\pod\Generator';
            }
            if (!isset($app->getModule('gii')->generators['giiant-goodmall-model'])) {
                $app->getModule('gii')->generators['gii-goodmall-model'] =
                  Generator::className();
            }

             /*
            if (!isset($app->getModule('gii')->generators['giiant-test'])) {
                $app->getModule('gii')->generators['giiant-test'] = 'schmunk42\giiant\generators\test\Generator';
            }*/

            if ($app instanceof \yii\console\Application) {
                $app->controllerMap['giigoodmall-batch'] = 'year\gii\goodmall\commands\BatchController';
            }
        }
    }
}
