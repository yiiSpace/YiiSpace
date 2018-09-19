<?php

namespace year\gii\yunying4java;

use year\gii\yunying4java\generators\model\Generator;
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
     * yunying 中gii的基
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
        // 文件选择器使用
        $app->controllerMap['file-tree'] = [
            'class' =>FileTreeController::className(),
            // 'module' => $this,
        ];

        if ($app->hasModule('gii')) {

            $gkey = 'yunying4java-model';
            if (!isset($app->getModule('gii')->generators[$gkey])) {
                $app->getModule('gii')->generators[$gkey] = Generator::className();
            }

             /*
            if (!isset($app->getModule('gii')->generators['giiant-test'])) {
                $app->getModule('gii')->generators['giiant-test'] = 'schmunk42\giiant\generators\test\Generator';
            }*/

            if ($app instanceof \yii\console\Application) {
                $app->controllerMap['giiyunying-batch'] = 'year\gii\yunying4java\commands\BatchController';
            }
        }
    }
}
