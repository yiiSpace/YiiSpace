<?php
/**
 * User: yiqing
 * Date: 14-8-27
 * Time: 上午11:57
 */

namespace year\api\base;

use app\helpers\StringHelper;
use Yii;
use yii\base\Component;
use yii\base\Configurable;
use yii\base\Model;
use yii\base\Module;
use yii\base\NotSupportedException;
use yii\helpers\ArrayHelper;

/**
 * @see http://json-rpc.org/wiki/specification
 *
 * 关于请求响应格式可以参考jsonRpc规范
 * 在golang方法调用的多值返回形式也可以借鉴 （经常有一个error表示是否有错误 ，如果为null则表示成功 这种风格强调了错误处理优先
 * 的理念）
 *
 * TODO 通过URL重写可以伪装请求格式  api/v1/<methodName>  然后参数部分可以通过queryString 或者post传递
 *
 * Class Runner
 * @package year\api\base
 */
class Runner extends Component
{


    /**
     * 请求使用的http方法
     *
     * @var string
     */
    protected $requestMethod = 'GET';
    /**
     *请求传递的参数 里面一般有method params [key] 字段
     *
     * @var array
     */
    protected $requestParams = array();


    /**
     * api 请求标识
     *
     * 该字段在批量调用时一并返回
     * 比如批量call时是顺序调用 但在服务端使用了并行处理 那么需要此key来保证返回结果不会乱序
     *
     * @var null
     */
    public $apiMethodId = null;

    /**
     * api 请求标识的名称
     *
     * @var string
     */
    public $apiMethodIdParam = 'key';

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        // ----------------------------------------------------------------\\
        #  判断当前请求的方法类型
        $this->requestMethod = \Yii::$app->request->getMethod();
        // ----------------------------------------------------------------//
        // 注册错误处理器跟异常处理器
        // set_error_handler(array($this, 'errorHandler'), E_ERROR);
        // set_exception_handler(array($this, 'exceptionHandler'));
    }

    /**
     * 设置请求参数  可以模拟请求
     *
     * @param array $params
     */
    public function setRequestParams($params = array())
    {
        $this->requestParams = $params;
    }

    /**
     * 返回请求参数
     * @return array
     */
    public function getRequestParams()
    {

        if (empty($this->requestParams)) {

            // FIXME is this equal to $_REQUEST
            $get = is_array(\Yii::$app->request->get()) ? \Yii::$app->request->get() : [];
            // $this->requestParams =  $get + \Yii::$app->request->post();
            $this->requestParams = ArrayHelper::merge($get, \Yii::$app->request->post());
            // print_r($_POST);
        }
        return $this->requestParams;
    }

    /**
     * which module should handle current api
     *
     * @var null|Module|string
     */
    protected $module = null;

    /**
     * @param null|Module|string $module
     */
    public function setModule($module = null)
    {
        $this->module = $module;
    }

    /**
     * 返回当前处理该api请求的模块
     * 为null时表示由全局处理
     *
     * @param string $method
     * @return null|string|Module
     */
    public function getModule($method)
    {
        // 重置module  批量处理时防止继承上次调用的module解析
        // unset($this->module);
//        print_r($this->hostModules);
//        die(__METHOD__);
//        // try wildcard matching
        foreach ($this->hostModules as $pattern => $module) {
            if (strpos($pattern, '*') > 0 && strpos($method, rtrim($pattern, '*')) === 0) {
                $this->module = $module;
            }
        }
        if (is_string($this->module)) {
            $this->module = \Yii::$app->getModule($this->module);
        }
        return $this->module;
    }

    protected function prepare()
    {

    }


    /**
     * api应该在那个module下运行
     * 如：
     *     ['user.*'=>'user',]
     *   表示以user.开头的应该在user模块下运行
     *
     * TODO 此处也可以采用自动发现+缓存实现 如果模块开发者忘记注册自己的服务类也可以自动暴露给外部？
     *
     * @var array
     */
    public $hostModules = [];

    /**
     * @var array
     */
    protected $apiHandlerMap = array(
        'xxxxxxxxxxx.xxxx.xxxx' => 'XXXModule.XxxxxxxService.method',
    );

    /**
     * @param array $array
     * @return bool
     */
    public static function isAssociative(array &$array)
    {
//        foreach(array_keys($a) as $key)
//            if (!is_int($key)) return TRUE;
//        return FALSE;
        reset($array);
        $k = key($array);
        return !(is_int($k) || is_long($k));
    }

    /**
     * 根据方法名称来创建api宿主对象 和方法名称
     *
     * @param $apiMethod
     * @return array
     * @throws MethodNameException
     * @throws \yii\base\InvalidConfigException
     */
    public function resolveApiHandler($apiMethod)
    {
        // 重置下当前模块 防止循环调用时 效果继承上次运行的一些值设定
        $this->module = null;
        // 根据api方法名找其寄居的模块
        $module = $this->getModule($apiMethod);
        if (null == $module) {
            $module = \Yii::$app;
        }
        // die($module->controllerNamespace) ;
        // 根据当前模块获取其所在的名空间
        // $lastSlashPod = strrpos($module->controllerNamespace,'\\');
        //$moduleNameSpace = substr($module->controllerNamespace,0,- strlen('\controllers' ));
        $moduleNameSpace = substr($module->controllerNamespace, 0, strrpos($module->controllerNamespace, '\\controllers'));
        /*
        print_r(array(
           'currentModule'=>$moduleNameSpace ,
            'ns'=>(new \ReflectionObject($module))->getNamespaceName() ,
        ));
        exit;
         */

        //TODO 这个允许自己进行内部api处理映射 可以不遵从惯例寻址
        if (isset($this->apiHandlerMap[$apiMethod])) {

        }

        // 注意api方法串可能出现的情形 惯例是用"."点号分隔--参考淘宝那种
        $parts = explode('.', $apiMethod);
        $methodName = array_pop($parts);
        // 这个可能是当前模块下 或者是其他模块下的服务名
        // $serviceName = implode('/', array_map('ucfirst', $parts));
        $serviceName = ucfirst(array_pop($parts)) . 'Service';
        /*
        print_r(array(
           'methodName'=>$methodName,
            'serviceName'=>$serviceName ,
            'moduleNameSpace'=>$moduleNameSpace ,
        ));
        die(__METHOD__) ;
        */
        $serviceQualifiedName = $moduleNameSpace . "\\services\\{$serviceName}";
        // 注意service层的类名惯例  XxxService.class.php
        // $serviceObj = A(ucfirst($serviceName), 'Service');
        $serviceObj = \Yii::createObject($serviceQualifiedName);


        if ($serviceObj == false) {
            // 服务类名解析出错 证明类初次加载不成功 可以尝试其他策略 或者抛给客户端异常调用
            throw new MethodNameException(sprintf('no such service %s', $serviceName));
        }

        return [$serviceObj, $methodName];
    }

    /**
     * 根据请求的api方法串 跟api方法参数 创建service及其可被执行的参数
     *
     * @param string $apiMethod
     * @param array $apiParams TODO 存在数组复制！  改用地址传递?
     * @throws MethodNameException
     * @throws MethodParamException
     * @return array|bool a callable array [callbale,params]
     */
    protected function createApiHandler($apiMethod, $apiParams = array())
    {

        if (empty($apiMethod)) {
            // 服务类名没有传递
            throw new MethodNameException(sprintf('empty method !'));
        }

        //  系统处理 批量处理最好参考jsonRpc2.x规范中的批处理方式
        if ($apiMethod == 'batch') {
            // 批处理 小心递归现象啊！！！
            // 参数传递格式，{method:batchRun, params: [{},{},...]
            return array(
                array($this, 'batchRun'),
                $apiParams,
            );
        }
        list($serviceObj, $methodName) = $this->resolveApiHandler($apiMethod);

        // 利用反射 来调用服务类的某个方法
        if (!method_exists($serviceObj, $methodName)) {
            throw new MethodNameException(sprintf('no such method %s', $methodName));
        }
        $reflectionMethod = new \ReflectionMethod($serviceObj, $methodName);
        // print_r($rm->getParameters());
        $args = $apiParams;

        $pass = array();
        $missing = array();

        /**
         * TODO  这里需要参考 yii\di\Container 如果参数是特殊类型 作为依赖由容器负责实例化！
         * TODO  如果调用的Service 上面有注解类 那么可以玩的就更多了！
         */
        if (empty($args) || self::isAssociative($args)) {

            foreach ($reflectionMethod->getParameters() as $param) {
                /* @var $param ReflectionParameter */
                // print('the param: '.$param->getName().' <br/>');

                // if (is_subclass_of($param->getClass()->getName(), Model::className())) {
                if (is_a($param->getClass()->getName(), Model::className() , true)) {
                    // $args['class'] = $param->getClass()->getName() ;
                    // $pass[] =   Yii::createObject($args ) ;  // unset($args['class']) ; // $args[$param->getName()];
                    $modelInstance = $param->getClass()->newInstance();
                    $modelInstance->load($args,'') ; // 不需要 User['name'] = 'yiqing '  这种形式的传递
                    $pass[] = $modelInstance ;
                    continue ;
                }elseif(is_a($param->getClass()->getName(),Configurable::class , true)){
                    // 允许yii系统的 依赖注入了 ！
                    throw new NotSupportedException('暂时没有实现哦 ！ 这个也是比较简单的') ;
                }
                /*
                print_r(
                    [
                        'param-class-name' => $param->getClass()->getName() ,
                        'check-type'=>Model::className() ,
                        'param-name'=>$param->getName()  ,
                        'is-a'=> is_a($param->getClass()->getName() ,  Model::className() ,true) ? 'yes': 'no' ,
                    ]
                );
                die() ;
                */

                if (isset($args[$param->getName()])) {
                    $pass[] = $args[$param->getName()];
                } elseif ($param->isDefaultValueAvailable()) {
                    $pass[] = $param->getDefaultValue();
                } else {
                    $missing[] = $param->getName();
                }
            }
        } // 非关联数组形式传递的参数 不推荐此种形式调用！如果接口变化了可能会破坏掉向前/后 的兼容性
        else {
            $pass = $args;
            // 传递的参数 比方法参数少 那么需要检查是不是有遗漏
            // if(($pass_arg_count = count($pass)) < ($method_param_count = count($reflectionMethod->getParameters()))){
            if (($pass_arg_count = count($pass)) < ($num_required = $reflectionMethod->getNumberOfRequiredParameters())) {
                $allMethodParams = $reflectionMethod->getParameters();

                $missingParams = array_slice($allMethodParams, $pass_arg_count, $num_required - $pass_arg_count);
                foreach ($missingParams as $param) {
                    // print('the param: '.$param->getName().' <br/>');
                    /* @var $param ReflectionParameter */
                    $missing[] = $param->getName();
                }
            }
        }

        if (!empty($missing)) {
            throw new MethodParamException(sprintf('missing required parameters: %s ', implode(', ', $missing)));
        }

        return array(
            array($serviceObj, $methodName),
            $pass
        );

    }

    /**
     * TODO: 在方法调用前可以触发某事件  作为钩子
     *
     * @see https://www.yiiframework.com/doc/api/2.0/yii-base-event
     *
     *
     * @return mixed
     * @throws MethodNameException
     * @throws MethodNotAllowedException
     * @throws MethodParamException
     */
    public function run()
    {
        $requestParams = $this->getRequestParams();

        // return $requestParams ;

        // print_r($requestParams);
        if (!isset($requestParams['method'])) {
            throw new MethodNameException(sprintf('empty method !'));
        }
        $apiMethod = $requestParams['method'];


        // $apiMethodParams = isset($requestParams['params']) ? $requestParams['params'] : array();
        // 支持json参数
        if (isset($requestParams['jsonParam']) && !empty($requestParams['jsonParam'])) {
            $apiMethodParams = json_decode($requestParams['jsonParam'], true);
        } else {

            // DONE_TODO  这里可以利用某种松散形式 把所有除却系统指定的统一参数外的信息假设为是要传递给params的东西
            // 也就是GET|POST请求中不是 method ,token ,appKey..的参数
            // TODO 系统级参数 需要从其中过滤 array_may($sysParamNames,function($sysParamName){ unset($apiMethodParams[$sysParamName]) })


            // $apiMethodParams = isset($requestParams['params']) ? $requestParams['params'] : array();
            // $apiMethodParams = isset($requestParams['params']) ? $requestParams['params'] : $requestParams; // 没意义了
            $apiMethodParams = $requestParams;

        }
        // 当参数传给params 但是把json字符串赋给了它 此时再做次转换 这样 json串可以传递给jsonParam或者params都行
        //        if (is_string($apiMethodParams)) {
        //            // json字符串检测：
        //            $apiMethodParams = json_decode($apiMethodParams, true);
        //            if (json_last_error() == JSON_ERROR_NONE) {
        //                // 无错误那么传递的参数是合法json
        //            } else {
        //                throw new MethodParamException('params must be an array or validate json string ');
        //            }
        //
        //        }
        // 检测是否是合法的数组
        if (!empty($apiMethodParams) && !\yii\helpers\ArrayHelper::isAssociative($apiMethodParams)) {
            throw new MethodParamException('params must be an associative array ');
        }

        /**
         * 如果设置了请求id标识 那么赋值给apiMethodId ；
         */
        if (isset($requestParams[$this->apiMethodIdParam])) {
            $this->apiMethodId = $requestParams[$this->apiMethodIdParam];
        }

        list($handler, $params) = $this->createApiHandler($apiMethod, $apiMethodParams);

        $handlerObj = current($handler);
        $handlerMethodName = end($handler);
        //--------------------------------------------------------------------------------------------------\\
        /**
         * 本段进行服务方法的动词验证
         */

        if (method_exists(current($handlerObj), 'verbs') || $handlerObj instanceof Service) {
            // FixMe 这里用的抽象类 如果用接口标识是否更好些？
            $methodVerbMap = call_user_func(array($handlerObj, 'verbs'));
            // $handlerObj->verbs();
            // 服务类声明了方法保护
            if (!empty($methodVerbMap)) {
                if (isset($methodVerbMap[$handlerMethodName])) {
                    $methodVerbs = $methodVerbMap[$handlerMethodName];
                    if (is_string($methodVerbs)) {
                        $methodVerbs = array($methodVerbs);
                    }
                    $allowed = array_map('strtoupper', $methodVerbs);
                    if (!in_array($this->requestMethod, $allowed)) {
                        // http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.7
                        // Response()->getHeaders()->set('Allow', implode(', ', $allowed));
                        throw new MethodNotAllowedException('Method Not Allowed. This url can only handle the following request methods: ' . implode(', ', $allowed) . '.');
                    }
                }
            }
        }
        //--------------------------------------------------------------------------------------------------//
        //--------------------------------------------------------------------------------------------------\\
        if (method_exists($handlerObj, 'beforeMethod') || current($handlerObj) instanceof Service) {
            $serviceObj = $handlerObj;
            // 忽略返回值
            //  $_ = call_user_func_array(array($serviceObj, 'beforeMethod'), [$handlerMethodName]);
            $_ = $serviceObj->{'beforeMethod'}($handlerMethodName);
        }
        //--------------------------------------------------------------------------------------------------//
        /*
        var_dump(array(
            $handler,$params,
        ));
        die(__METHOD__);
        */
        $result = call_user_func_array($handler, $params);

        //--------------------------------------------------------------------------------------------------\\
        if (method_exists($handlerObj, 'afterMethod') || $handlerObj instanceof Service) {
            $serviceObj = $handlerObj;
            // 忽略返回值
            // $_result = call_user_func_array(array($serviceObj, 'afterMethod'), [$handlerMethodName,$result]);
            $_result = $serviceObj->{'afterMethod'}($handlerMethodName, $result);
            if (!empty($_result)) {
                $result = $_result;
            }
        }
        //--------------------------------------------------------------------------------------------------//

        // print_r($result);
        return $result;

    }


    /**
     * @return array
     */
    public function batchRun()
    {
        $batchCallParams = func_get_args();
        /*
        // 接下来遍历调用每个方法
        return array(
            'method' => __METHOD__,
            'params' => $batchCallParams,
        );
        */
        $results = array();
        foreach ($batchCallParams as $callParams) {
            $this->setRequestParams($callParams);
            $result = $this->run();
            if (null != $this->apiMethodId) {
                $results[$this->apiMethodId] = $result;
            } else {
                $results[] = $result;
            }
            // 要重置上次运行的涟漪效果
            // unset($this->module);
            // exit(__LINE__);
        }
        return $results;
    }


    //-----------------------------------------------------------------------------------\\
    ###  错误异常处理 两个php回调函数

    public function errorHandler($errno, $message, $file, $line)
    {

        $data = array(
            'error' => 1,
            'errno' => $errno,
            'message' => $message,
            'line' => $line,
            'file' => $file,
        );
        echo self::outputJson($data);
        exit(0);
    }

    public function exceptionHandler($e)
    {
        $data = array(
            'error' => 1,
            'errno' => $e->getCode(),
            'message' => $e->getMessage(),
        );
        exit(0);
    }

    protected function append_error_handler($handler)
    {
        $this->set_error_handlers(array(set_error_handler($handler), $handler));
    }

    protected function prepend_error_handler($handler)
    {
        $this->set_error_handlers(array($handler, set_error_handler($handler)));
    }

    protected function set_error_handlers($handlers)
    {
        $handlers = (is_array($handlers) ? $handlers : array($handlers));
        set_error_handler(function ($level, $message, $file = null, $line = null, $context = null) use ($handlers) {
            foreach ($handlers as $handler) {
                if ($handler) {
                    call_user_func($handler, $level, $message, $file, $line, $context);
                }
            }
        });
    }

    //-----------------------------------------------------------------------------------//
}