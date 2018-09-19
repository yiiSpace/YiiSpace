<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/5/24
 * Time: 22:31
 */

namespace my\test\services;

use yii\base\Object;

/**
 * 样例api
 *
 * 提供各种常见方法调用形式的返回值格式
 *
 * Class SampleService
 * @package my\test\services
 */
class SampleService extends Object{

    /**
     * 这是方法描述
     *
     * 这是长描述 你可以以测测！
     *
     * @MyTag('yes')
     *
     * @param string $name
     * @param int $sex 性别  默认是1 表男性
     * @return array 这里是返回值描述呢
     * 这里是返回值描述呢
     */
    public function create($name,$sex=1)
    {
        return [] ;
    }
}