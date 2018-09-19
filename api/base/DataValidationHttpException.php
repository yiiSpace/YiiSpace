<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/27
 * Time: 23:34
 */

namespace api\base;


use yii\web\HttpException;

/**
 * this is an exception which is not presented in the standard Exception collection of yii
 *
 * Class DataValidationHttpException
 * @package api\base
 */
class DataValidationHttpException extends HttpException{

    public $errors = [
        'test' => 'yee' ,
    ];

    /**
     * Constructor.
     * @param string $message error message
     * @param integer $code error code
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct(422, $message, $code, $previous);
    }
}