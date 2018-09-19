<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/5
 * Time: 10:33
 */

namespace monkey\object;


use monkey\helpers\CreateWith;

class ReturnValue  implements Object
{
    use CreateWith ;
    /**
     * @var \monkey\object\Object
     */
    public $Value ;

    /**
     * @return string
     */
    public function Type(): string
    {
        return ObjectType::RETURN_VALUE_OBJ ;
    }

    /**
     * @return string
     */
    public function Inspect(): string
    {
        return $this->Value->Inspect() ;
    }
}