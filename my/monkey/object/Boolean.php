<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/4
 * Time: 15:48
 */

namespace monkey\object;


use monkey\helpers\CreateWith;

class Boolean implements Object
{
    use  CreateWith ;
    /**
     * @var bool
     */
    public $Value ;

    /**
     * @return string
     */
    public function Type(): string
    {
       return ObjectType::BOOLEAN_OBJ ;
    }

    /**
     * @return string
     */
    public function Inspect(): string
    {
        return $this->Value == true ? 'true':'false' ;
       //  return sprintf("%s", $this->Value /*gettype($this->Value)*/) ;
    }
}