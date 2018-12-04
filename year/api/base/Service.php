<?php
/**
 * User: yiqing
 * Date: 14-8-27
 * Time: 上午11:57
 */

namespace year\api\base;


abstract class Service {

    /**
     * 声明那些方法可以使用什么类型的http方法（动词）来访问 如：
     *   return [
        'index' => ['GET', 'HEAD'],
        'view' => ['GET', 'HEAD'],
        'create' => ['POST'],
        'update' => ['PUT', 'PATCH'],
        'delete' => ['DELETE'],
        ];
     *
     * Declares the allowed HTTP verbs.
     * Please refer to [[VerbFilter::actions]] on how to declare the allowed verbs.
     * @return array the allowed HTTP verbs.
     */
    public  function verbs()
    {
        return array();
    }

    /**
     * @param string $methodName
     */
    public function beforeMethod($methodName)
    {

    }

    /**
     * @param string $methodName  方法名称
     * @param mix $result    the executed result of the method 方法执行的结果
     * @return null|mix  if return something which will be used to replace the original result ;
     *  如果返回了什么这个东西就会被用来作为最终的返回值的
     */
    public function afterMethod($methodName ,$result)
    {
    }
} 