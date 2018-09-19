<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/29
 * Time: 14:56
 */
namespace monkey\ast;

use monkey\helpers\CreateWith;

/**
 * Class Program
 * @package monkey\ast
 */
class Program implements Node
{
    use CreateWith ;

    /**
     * @var array|Node[]|Statement[]
     */
    public $Statements = [];

    /**
     * @return string
     */
    public function TokenLiteral(): string
    {
        if(count($this->Statements) >0 ){
            return $this->Statements[0]->TokenLiteral() ;
        }
        return '' ;
    }

    /**
     * @return string
     */
    public function String(): string
    {
        $out = '' ;
        foreach ($this->Statements as $i=>$statement){
            $out .= $statement->String() ;
        }
        return $out ;
    }
}