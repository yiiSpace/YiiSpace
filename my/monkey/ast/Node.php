<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/29
 * Time: 14:53
 */

namespace monkey\ast;


interface Node
{
    /**
     * @return string
     */
    public function TokenLiteral() :string  ;

    /**
     * @return string
     */
    public function String():string ;

}