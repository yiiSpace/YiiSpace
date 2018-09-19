<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/4
 * Time: 15:41
 */

namespace monkey\object;


use monkey\helpers\CreateWith;

class Integer implements Object
{
    use CreateWith ;

    /**
     * @var int
     */
    public $Value = 0 ;


    /**
     * @return string
     */
    public function Type(): string
    {
        return ObjectType::INTEGER_OBJ ;
    }

    /**
     * @return string
     */
    public function Inspect(): string
    {
      return sprintf("%d",$this->Value);
    }
}