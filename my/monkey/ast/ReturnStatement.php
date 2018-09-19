<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/30
 * Time: 15:22
 */

namespace monkey\ast;


use monkey\helpers\CreateWith;
use monkey\token\Token;

class ReturnStatement implements Statement
{
    use CreateWith ;

    /**
     * the 'return' token
     *
     * @var Token
     */
    public $Token  ;

    /**
     * @var Expression
     */
    public $ReturnValue ;
    /**
     * @return string
     */
    public function TokenLiteral(): string
    {
        return $this->Token->Literal ;
    }

    public function statementNode()
    {

    }

    /**
     * @return string
     */
    public function String(): string
    {
       $out = '';
       $out .= $this->TokenLiteral() . ' ';

       if($this->ReturnValue != null ){
           $out .= $this->ReturnValue->String() ;
       }
       $out .= ';';
       return $out ;
    }
}