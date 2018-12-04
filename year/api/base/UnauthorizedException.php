<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/5/15
 * Time: 9:35
 */

namespace year\api\base;

/**
 * 未授权异常 需要登录才能进行操作
 *
 * Class UnauthorizedException
 * @package year\api\base
 */
class UnauthorizedException extends ApiClientException{

    /**
     * @param null $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct( $message = null, $code = 0, \Exception $previous = null)
    {
        if($message === null){
            $message = '未授权';
        }
        parent::__construct( 401, $message, $code, $previous);
    }
}