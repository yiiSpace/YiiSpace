<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/12/9
 * Time: 18:17
 */

namespace year\api\service;

use Yii ;
use yii\base\Component;
use yii\base\Configurable;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\web\BadRequestHttpException;

/**
 * TODO: 异常类型不应该耦合到web层 使用http层的异常 这样导致下层依赖了上层 依赖方向有问题  应该有自己的异常层次！
 *
 * Class ServiceMethodExecutor
 * @package year\api\service
 */
class ServiceMethodExecutor extends Component
{
    /**
     * @var string
     */
    protected $serviceClass  ;
    /**
     * @var null
     */
    protected $serviceObj =  null ;

    /**
     * @param $serviceObj
     * @return $this
     */
    public function setServiceObject($serviceObj)
    {
        $this->serviceObj = $serviceObj ;
        return $this ;
    }

    /**
     * @return null
     */
    public function getServiceObject()
    {
        return $this->serviceObj ;
    }

    /**
     * @see https://stackoverflow.com/questions/888064/php-5-3-magic-method-invoke
     *
     * @param $method
     * @param array $params
     * @return mixed
     * @throws BadRequestHttpException
     * @throws InvalidConfigException
     * @throws \ReflectionException
     */
    public function invoke($method , $params = [])
    {

        $serviceObj = $this->getServiceObject() ;
        if(empty($this->serviceObj)){
            throw new InvalidConfigException('you must set the serviceClass or serviceObject properties! ');
        }


        $methodParams = $this->buildMethodParams($method ,$params) ;

        return call_user_func_array([$serviceObj,$method] , $methodParams) ;
    }

    public function __call($name, $arguments)
    {
        //   todo return $this->invoke($name ,)
        throw new Exception('not implemented !') ;
    }

    public function setServiceClass($serviceClass )
    {
        $this->serviceClass = $serviceClass ;
        // FIXME 类形是简单形式！
        $this->serviceObj = \Yii::createObject($this->serviceClass) ;
        return $this ;
    }
    public function getServiceClass()
    {
        return $this->serviceClass ;
    }

    /**
     * @see Controller::bindActionParams
     *
     * @param $method
     * @param $params
     * @return array
     * @throws BadRequestHttpException
     * @throws \ReflectionException
     */
    protected function buildMethodParams($method , $params)
    {
        $method = new \ReflectionMethod($this->serviceObj,$method);

        $args = [];
        $missing = [];

        foreach ($method->getParameters() as $param) {
            /* @var $param ReflectionParameter */


            // print('the param: '.$param->getName().' <br/>');
            // if (is_subclass_of($param->getClass()->getName(), Model::className())) {
            if( !isset($params[$param->getName()]) && $param->getClass() != null){
                // TODO: 此处可用暴露一个回调 遇到特定类执行不同的参数实例化 (Closure function(){ ... } )
                // 不同的类名 对应不同的回调方法  setParamInitializer($paramClass , Closure callback )
                // 一个用到的场景就是 模型除了填充外 还要设置一个额外的 scenario
                if (is_a($param->getClass()->getName(), Model::className() , true)) {
                    // $args['class'] = $param->getClass()->getName() ;
                    // $pass[] =   Yii::createObject($args ) ;  // unset($args['class']) ; // $args[$param->getName()];
                    $modelInstance = $param->getClass()->newInstance();
                    $modelInstance->load($params,'') ; // 不需要 User['name'] = 'yiqing '  这种形式的传递
                    $args[] = $modelInstance ;
                    continue ;
                }elseif(is_a($param->getClass()->getName(),Configurable::class , true)){
                    // 允许yii系统的 依赖注入了 ！
                    throw new NotSupportedException('暂时没有实现哦 ！ 这个也是比较简单的') ;
                }
            }


            $name = $param->getName();
            if (array_key_exists($name, $params)) {
                if ($param->isArray()) {
                    $args[] =  (array) $params[$name];
                } elseif (!is_array($params[$name])) {
                    $args[]  = $params[$name];
                } else {
                    throw new BadRequestHttpException(Yii::t('yii', 'Invalid data received for parameter "{param}".', [
                        'param' => $name,
                    ]));
                }
                unset($params[$name]);
            } elseif ($param->isDefaultValueAvailable()) {
                $args[]  = $param->getDefaultValue();
            } else {
                $missing[] = $name;
            }
        }

        if (!empty($missing)) {
            throw new BadRequestHttpException(Yii::t('yii', 'Missing required parameters: {params}', [
                'params' => implode(', ', $missing),
            ]));
        }

        return $args;
    }

}