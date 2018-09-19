<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/29
 * Time: 14:53
 */

namespace monkey\ast;


interface Statement extends Node
{
    public function statementNode() ;
}