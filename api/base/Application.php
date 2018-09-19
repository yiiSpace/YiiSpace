<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/27
 * Time: 23:07
 */

namespace api\base;

use \Yii ;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;
use yii\web\Response;

/**
 * 所有该应用下的控制器 除了apidoc模块下的控制器外 都需要是 yii\rest\Controller 类的子类
 *
 * Class Application
 * @package api\base
 *
 * @todo 事件监听哪里 不能取消 |   runAction 也应该预留一个口 可以取消参数合并 （比如在某actionXXX 里面调用Yii::$app->runAction()）
 */
class Application extends \yii\web\Application{

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {

        // 置换掉原始的动作结果序列化器
        $currentController = $action->controller ;
        if($currentController instanceof Controller){
            // 使用我们自己的结果序列化器
            $currentController->serializer = Serializer::className() ; //    $action->controller->se = 'yii\rest\Serializer';

        }
        //====================================================================================================\\
        //  对于非apiDoc 模块的所有控制器串改返回结果

        if( ( Yii::$app->controller->module !== null)
            && Yii::$app->controller->module instanceof \my\apidoc\Module){

        }else{
            // 禁用csrf验证
            Yii::$app->controller->enableCsrfValidation = false ;

            // 非apidoc 模块的所有处理改写其返回值
            // TODO 事件监听器 需要变成非匿名函数 以便其他地方 在响应发生前 可以取消串改(->off(...))结果的需求 ['SomeClass','StaticMethod']
            $this->getResponse()->on(Response::EVENT_BEFORE_SEND,function ($event) {

                /*
                 * 此时的控制器 和module竟然都被置空了
                 *
                print_r([
                    'controllerClass'=>(Yii::$app->controller) ,
                    'moduleClass'=>(Yii::$app->controller->module),
                ]);
                */

                /**
                 * @var \yii\web\Response $response
                 */
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
//               print_r($response->data) ; die(__METHOD__) ;
            });

            // 如果非rest控制器 那么抛异常示警 不然错误很难找到
            if(! $currentController instanceof Controller){
               throw new Exception('the controller must be an instance of yii\rest\Controller , but now it is '.$currentController->className());
            }
        }
        //====================================================================================================//



        if (!parent::beforeAction($action)) {
            return false;
        }
        // do some global action-filter !


        return true;
    }

    /**
     * Runs a controller action specified by a route.
     * This method parses the specified route and creates the corresponding child module(s), controller and action
     * instances. It then calls [[Controller::runAction()]] to run the action with the given parameters.
     * If the route is empty, the method will use [[defaultRoute]].
     * @param string $route the route that specifies the action.
     * @param array $params the parameters to be passed to the action
     * @return mixed the result of the action.
     * @throws InvalidRouteException if the requested route cannot be resolved into an action successfully
     */
    public function runAction($route, $params = [])
    {
        // 如果不是get请求 合并post请求的参数
        /**
         * 关于这个做法的思路 可以参考：
         * - http://revel.github.io/manual/parameters.html
         * - https://github.com/go-martini/martini#service-injection
         * - http://symfony.com/doc/current/book/controller.html#route-parameters-as-controller-arguments
         *
         * 这里的params 可以认为是get | post | cookie .. 的合并 是一种注入思想  在这里主要用来生成phpDoc的！！！
         *
         * yii默认只从get请求提取（通过route正则匹配的也算哦！
         * 如： '<controller:(post|comment)>/<id:\d+>/<action:(create|update|delete)>' => '<controller>/<action>',
         * 如上示，id是可以被注入的参数）
         *
         * ~~~
         * $request = new Request(
                $_GET,
                $_POST,
                array(),
                $_COOKIE,
                $_FILES,
                $_SERVER
                );
         * ~~~
         */
        if(! Yii::$app->request->getIsGet()){
            $params = ArrayHelper::merge($params,Yii::$app->request->post());

        }
        /*
        print_r(
           [
            $params,
               Yii::$app->request->getMethod(),
               Yii::$app->request->post() ,
           ]
        ) ; die(__METHOD__) ;
        */
        return parent::runAction($route,$params) ;
    }
}