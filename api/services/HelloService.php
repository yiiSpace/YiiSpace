<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/12/4
 * Time: 13:09
 */

namespace api\services;

/**
 * api 服务测试
 * - 访问路径：http://127.0.0.1:5000/YiiSpace/api/web/v1/hello.to?name=something&arg1=hahaha
 *
 * Class HelloService
 * @package api\services
 */
class HelloService
{
    public function to( $name = 'yiqing')
    {
        return 'hello to '.$name ;
    }

}