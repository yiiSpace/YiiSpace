<?php
/**
 * User: yiqing
 * Date: 14-8-28
 * Time: 上午10:50
 */

namespace year\api\base;


class MethodNotAllowedException extends ApiClientException{

    public function __construct( $message = null, $code = 0, \Exception $previous = null)
    {
        if($message === null){
            $message = '该http方法不被允许';
        }

        parent::__construct( 405, $message, $code, $previous);
    }
} 