<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/4
 * Time: 9:18
 */

namespace monkey\ast;


use monkey\helpers\CreateWith;
use monkey\token\Token;

class CallExpression implements Expression
{
    use CreateWith;
    /**
     * @var Token
     */
    public $Token;

    /**
     * @var Expression
     */
    public $Function;

    /**
     * @var array|Expression[]
     */
    public $Arguments;

    public function expressionNode()
    {
        // TODO: Implement expressionNode() method.
    }

    /**
     * @return string
     */
    public function TokenLiteral(): string
    {
        return $this->Token->Literal;
    }

    /**
     * @return string
     */
    public function String(): string
    {
        $out = '';

        $args = [];
        foreach ($this->Arguments as $i => $argument) {
            $args[] = $argument->String();
        }

        $out .= $this->Function->String();
        $out .= '(';
        $out .= join(', ', $args);
        $out .= ')';

        return $out;
    }
}