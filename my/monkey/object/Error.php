<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/5
 * Time: 22:01
 */

namespace monkey\object;


use monkey\helpers\CreateWith;

/**
 *  生产环境下 是有stack trace的
 *
 * Class Error
 * @package monkey\object
 */
class Error implements Object
{

    use CreateWith ;

    /**
     * @var string
     */
    public $Message ;

    /**
     * @return string
     */
    public function Type(): string
    {
       return ObjectType::ERROR_OBJ ;
    }

    /**
     * @return string
     */
    public function Inspect(): string
    {
        return 'ERROR: '.$this->Message ;
    }
}