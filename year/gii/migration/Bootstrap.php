<?php

namespace year\gii\migration;

use year\gii\migration\generators\model\Generator;
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
        // 文件选择器使用
        $app->controllerMap['file-tree'] = [
            'class' =>FileTreeController::className(),
            // 'module' => $this,
        ];

        if ($app->hasModule('gii')) {

            $gk = 'migration' ;
            if (!isset($app->getModule('gii')->generators[$gk])) {
                $app->getModule('gii')->generators[$gk] =
                    \year\gii\migration\generators\migration\Generator::className() ;
            }



            if ($app instanceof \yii\console\Application) {
                $app->controllerMap['migration-batch'] = 'year\gii\migration\commands\BatchController';
            }
        }
    }
}
