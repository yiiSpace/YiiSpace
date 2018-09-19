<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/4
 * Time: 15:40
 */

namespace monkey\object;

/**
 * Interface Object
 * @package monkey\object
 */
interface Object
{
    /**
     * @return string
     */
    public function Type() :string  ;

    /**
     * @return string
     */
    public function Inspect():string  ;

}