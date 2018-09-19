<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/29
 * Time: 15:03
 */
namespace monkey\ast;


use monkey\helpers\CreateWith;
use monkey\token\Token;

class LetStatement implements Statement
{

    use CreateWith ;

    /**
     * @var Token
     */
    public $Token ;

    /**
     * @var Identifier
     */
    public $Name  ;

    /**
     * @var Expression
     */
    public $Value  ;

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
        $out = '';
        $out .= $this->TokenLiteral().' ';
        $out .= $this->Name->String() ;
        $out .= ' = ';

        if($this->Value != null){
            $out .= $this->Value->String() ;
        }
        $out .= ';';
        return $out ;
    }
}