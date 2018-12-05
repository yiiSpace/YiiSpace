<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/12/4
 * Time: 13:09
 */

namespace api\services;
use yii\base\Model;

/**
 * api 服务测试
 * - 访问路径：http://127.0.0.1:5000/YiiSpace/api/web/v1/hello.to?name=something&arg1=hahaha
 *
 * Class HelloService
 * @package api\services
 */
class HelloService
{
    /**
     *
     * @param string $name
     * @return string
     */
    public function to( $name = 'yiqing')
    {
        return 'hello to '.$name ;
    }

    /**
     * url : http://127.0.0.1:5000/YiiSpace/api/web/v1/hello.foo?name=yiqing
     *
     * @param HelloModel $someModel name 会被url中的参数自动填充！
     * @return array
     */
    public function foo(  HelloModel $someModel )
    {
        return [
            'from'=>HelloService::class ,
            'model'=>$someModel->toArray() ,
        ] ;
    }

}

class HelloModel  extends Model {
    /**
     * @var string
     */
    public $name  ;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

}