<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/2
 * Time: 14:03
 */

namespace monkey\ast;


use monkey\helpers\CreateWith;
use monkey\token\Token;

class InfixExpression implements Expression
{
    use CreateWith ;
    /**
     * @var Token
     */
    public $Token;

    /**
     * @var Expression
     */
    public $Left;

    /**
     * @var string
     */
    public $Operator;

    /**
     * @var Expression
     */
    public $Right;


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
        $out = '';

        $out .= '(';
        $out .= $this->Left->String();
        $out .= ' '.$this->Operator.' ';
        $out .= $this->Right->String();
        $out .= ')';

        return $out;
    }
}