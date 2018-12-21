<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/7/26
 * Time: 5:09
 */

namespace api\controllers;


use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use api\services\HelloService;
use year\api\service\ServiceMethodExecutor;

/**
 * Class HelloController
 * @package api\controllers
 *
 * @OA\Info(title="My First API", version="0.1")
 */
class HelloController extends Controller
{


    /**
     * @return ServiceMethodExecutor
     */
    protected function getServiceMethodExecutor()
    {
        $serviceExecutor = new ServiceMethodExecutor();
        $serviceExecutor->setServiceClass(HelloService::class);
        return $serviceExecutor;
    }

    /**
     * @var callable a PHP callable that will be called when running an action to determine
     * if the current user has the permission to execute the action. If not set, the access
     * check will not be performed. The signature of the callable should be as follows,
     *
     * ```php
     * function ($action, $model = null) {
     *     // $model is the requested model instance.
     *     // If null, it means no specific model (e.g. IndexAction)
     * }
     * ```
     */
    public $checkAccess;


    /**
     * http://127.0.0.1:666/api/web/index.php?r=hello/to
     *
     * @OA\Get(
     *     path="/hello/to.json",
     *     @OA\Response(response="200", description="An example resource")
     * )
     */
    public function actionTo()
    {
        $that = $this;
        $checkAccess = function ($action, $model) {

            var_dump(func_get_args());
            die(__FILE__);
        };
        $actionId = $this->action->getUniqueId();


        return $this->getServiceMethodExecutor()
//            ->invoke('to' , \Yii::$app->request->get()) ;
            ->invoke('to', [
                'checkAccess' => function ($model) use ($checkAccess, $actionId) {
                    if (is_callable($checkAccess)) {
                        call_user_func($checkAccess, $actionId, $model);
                    }
                }
            ]);
    }
}