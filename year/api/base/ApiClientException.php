<?php
/**
 * User: yiqing
 * Date: 14-8-27
 * Time: 下午2:33
 */

namespace year\api\base;



use yii\web\HttpException;

/**
 * 异常层次： HttpException ==> UserException ==> Exception ==> \Exception(php 核心异常)
 *
 * Class ApiClientException
 * @package year\api\base
 */
abstract class ApiClientException extends HttpException{

    /**
     * 业务异常编码
     *
     * @var int
     */
    public $bizCode = 2000 ;


    public function setBizCode($bizCode=0)
    {
        $this->bizCode = $bizCode ;
        return $this ;
    }

} 