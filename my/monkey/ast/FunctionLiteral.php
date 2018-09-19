<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/4
 * Time: 8:36
 */

namespace monkey\ast;


use monkey\helpers\CreateWith;
use monkey\token\Token;

class FunctionLiteral implements Expression
{
    use CreateWith ;
    /**
     * @var Token
     */
    public $Token ;

    /**
     * @var array|Identifier[]
     */
    public $Parameters ;
    /**
     * @var BlockStatement
     */
    public $Body ;

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
        $out = '' ;

        $params = [] ;
        foreach($this->Parameters as $parameter){
            $params[] = $parameter->String() ;
        }

        $out .= $this->TokenLiteral() ;
        $out .= '(';
        $out .= join(', ',$params);
        $out .= ') ';
        $out .= $this->Body->String() ;

        return $out ;
    }
}