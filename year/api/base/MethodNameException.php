<?php
/**
 * User: yiqing
 * Date: 14-8-27
 * Time: 下午2:58
 */

namespace year\api\base;


class MethodNameException extends ApiClientException{

    public function __construct( $message = null, $code = 0, \Exception $previous = null)
    {
        if($message == null){
            $message = '方法名称异常';
        }
        parent::__construct(400 , $message, $code, $previous);
    }

} 