<?php

namespace year\gii\dva;

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
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        if ($app->hasModule('gii')) {
            if (!isset($app->getModule('gii')->generators['giiant-dva'])) {
                $app->getModule('gii')->generators['gii-dva'] = 'year\gii\dva\generators\model\Generator';
            }

             /*
            if (!isset($app->getModule('gii')->generators['giiant-test'])) {
                $app->getModule('gii')->generators['giiant-test'] = 'schmunk42\giiant\generators\test\Generator';
            }*/

            if ($app instanceof \yii\console\Application) {
                $app->controllerMap['giidva-batch'] = 'year\gii\dva\commands\BatchController';
            }
        }
    }
}
