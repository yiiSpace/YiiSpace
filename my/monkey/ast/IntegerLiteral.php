<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/1
 * Time: 23:06
 */

namespace monkey\ast;


use monkey\helpers\CreateWith;
use monkey\token\Token;

class IntegerLiteral  implements Expression
{
    use CreateWith ;
    /**
     * @var Token
     */
    public $Token ;

    /**
     * @var int
     */
    public $Value ;

    public function expressionNode()
    {
        // TODO: Implement expressionNode() method.
    }

    /**
     * @return string
     */
    public function TokenLiteral(): string
    {
      return  $this->Token->Literal ;
    }

    /**
     * @return string
     */
    public function String(): string
    {
       return $this->Token->Literal ;
    }
}