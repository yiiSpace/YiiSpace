<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/3
 * Time: 19:32
 */

namespace monkey\ast;


use monkey\helpers\CreateWith;
use monkey\token\Token;

class BlockStatement implements Statement
{

    use  CreateWith ;
    /**
     * @var Token
     */
    public $Token ;

    /**
     * @var Statement[]
     */
    public $Statements = [] ;

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

        foreach ($this->Statements as $i=>$statement){
            $out .= $statement->String() ;
        }

        return $out ;
    }

    public function statementNode()
    {
        // TODO: Implement statementNode() method.
    }
}