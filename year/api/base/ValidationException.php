<?php
/**
 * User: yiqing
 * Date: 14-9-5
 * Time: 下午3:18
 */

namespace year\api\base;

/**
 * 数据验证失败
 *
 * Class ValidationException
 * @package year\api\base
 */
class ValidationException extends ApiClientException {

    /**
     * @param null $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct( 422 , $message, $code, $previous);
    }

} 