<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/3
 * Time: 11:58
 */

namespace monkey\ast;


use monkey\helpers\CreateWith;
use monkey\token\TokenType;

class IfExpression implements Expression
{

    use CreateWith ;
    /**
     * @var Token
     */
    public $Token;
    /**
     * @var Expression
     */
    public  $Condition;
    /**
     * @var BlockStatement
     */
    public $Consequence ;

    /**
     * @var BlockStatement
     */
    public $Alternative ;

    public function expressionNode()
    {
        // TODO: Implement expressionNode() method.
    }

    /**
     * @return string
     */
    public function TokenLiteral(): string
    {
        return $this->Token->Literal ;
    }

    /**
     * @return string
     */
    public function String(): string
    {
       $out  = '';

       $out .= 'if';
       $out .= $this->Condition->String() ;
       $out .= ' ';
       $out .= $this->Consequence->String() ;

       if($this->Alternative != null){
           $out .= 'else ';
           $out .= $this->Alternative->String() ;
       }

       return $out ;

    }
}