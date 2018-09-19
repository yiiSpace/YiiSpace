<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/30
 * Time: 20:41
 */
namespace monkey\ast;


use monkey\helpers\CreateWith;
use monkey\token\Token;

class ExpressionStatement implements Statement
{
    use CreateWith ;

    /**
     * @var Token
     */
    public $Token  ;

    /**
     * @var Expression
     */
    public  $Expression ;

    /**
     * @return string
     */
    public function TokenLiteral(): string
    {
       return $this->Token->Literal ;
    }

    public function statementNode()
    {
        // TODO: Implement statementNode() method.
    }

    /**
     * @return string
     */
    public function String(): string
    {
        if($this->Expression != null ){
            return $this->Expression->String() ;
        }
        return '' ;
    }
}