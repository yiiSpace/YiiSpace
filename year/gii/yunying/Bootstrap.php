<?php

namespace year\gii\yunying;

use year\gii\yunying\generators\model\Generator;
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

            if (!isset($app->getModule('gii')->generators['yunying-api'])) {
                $app->getModule('gii')->generators['yunying-api'] = \year\gii\yunying\generators\api\Generator::className();
            }

            if (!isset($app->getModule('gii')->generators['yunying-model'])) {
                $app->getModule('gii')->generators['yunying-model'] = Generator::className();
            }

            if (!isset($app->getModule('gii')->generators['giiant-yunying-pod'])) {
                $app->getModule('gii')->generators['gii-yunying-pod'] = 'year\gii\yunying\generators\pod\Generator';
            }

             /*
            if (!isset($app->getModule('gii')->generators['giiant-test'])) {
                $app->getModule('gii')->generators['giiant-test'] = 'schmunk42\giiant\generators\test\Generator';
            }*/

            if ($app instanceof \yii\console\Application) {
                $app->controllerMap['giiyunying-batch'] = 'year\gii\yunying\commands\BatchController';
            }
        }
    }
}
