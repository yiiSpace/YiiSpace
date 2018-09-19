<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/29
 * Time: 15:05
 */

namespace monkey\ast;

use monkey\helpers\CreateWith;
use monkey\token\Token;

class Identifier implements Expression
{
    use CreateWith ;

    /**
     * @var Token
     */
    public $Token  ;
    /**
     * @var string
     */
    public $Value ;

    public function expressionNode()
    {
        // TODO: Implement expressionNode() method.
    }

    public function TokenLiteral(): string
    {
        return $this->Token->Literal ;
    }

    /**
     * @return string
     */
    public function String(): string
    {
       return $this->Value ;
    }
}