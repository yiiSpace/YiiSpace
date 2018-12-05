<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/12/4
 * Time: 9:25
 */

namespace year\api\base;

/**
 * Class ServiceProxy
 * @package year\api\base
 */
class ServiceProxy
{

    /**
     * @var string
     */
    protected $target ;

    /**
     * TODO 可以扩展的功能: 使用AOP扩展目标类 | 使用钩子方法（beforeCreate afterDelete..）| 使用中间件机制
     * TODO  YII 的DI  有解析依赖的能力  这样service对象 如果依赖了外部组件 可以声明在其构造方法中 但服务实例的创建需要用YII的形式了
     *
     *
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     * @throws \ReflectionException
     */
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
       $rc =  new \ReflectionClass($this->target) ;
       // TODO:  使用annotation 提取目标类上的注解 来进行额外的操作
       // FIXME 目标类 如果是yii对象 方法集可能通过behavior来扩充
       //  if($rc->hasMethod($name)) {} //
        try{
            $method = $rc->getMethod($name) ;

            if (is_string($this->target)){
               // $this->target =  $rc->newInstance();
            }
            // TODO 可以触发一些事件 https://www.yiiframework.com/doc/api/2.0/yii-base-event#trigger()-detail
            // TODO 执行前扩展
            $return = $method->invokeArgs($this->target , $arguments) ;
            // TODO 执行后扩展
            return $return ;
        }catch (\Exception $ex){
            // TODO afterThrowing  抛异常后的扩展
            throw $ex ;
        }
    }
}