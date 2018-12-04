<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/7/21
 * Time: 13:37
 */

namespace year\api\base;

/**
 * Class ForbiddenException
 * @package year\api\base
 */
class ForbiddenException extends  ApiClientException
{

    /**
     * @param null $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct( $message = null, $code = 0, \Exception $previous = null)
    {
        if($message === null){
            $message = ' 鉴权成功，但是该用户没有权限';
        }

        parent::__construct( 403, $message, $code, $previous);
    }
}