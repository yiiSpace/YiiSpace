<?php

namespace year\gii\gogen;

use year\gii\gogen\generators\tags\Generator;
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
            'class' =>\year\gii\common\FileTreeController::className(),
            // 'module' => $this,
        ];

        if ($app->hasModule('gii')) {

            $gk = 'gogen-tags' ;
            if (!isset($app->getModule('gii')->generators[$gk])) {
                $app->getModule('gii')->generators[$gk] =
                   Generator::className();
            }

        }
    }
}
