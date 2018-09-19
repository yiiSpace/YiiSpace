<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/1
 * Time: 14:09
 */
namespace yiiunit\extensions\monkey\ast;

use monkey\ast\Identifier;
use monkey\ast\LetStatement;
use monkey\ast\Program;
use monkey\token\Token;
use monkey\token\TokenType;
use yiiunit\extensions\monkey\TestCase;

/**
 * Class AstTest
 * @package yiiunit\extensions\monkey\ast
 */
class AstTest extends TestCase
{
    /**
     *
     */
    public function testString()
    {
        $program = new Program();
        $statements = [];
        $letStatement = new LetStatement();

        $token = new Token();
        $token->Type = TokenType::LET;
        $token->Literal = 'let';
        $name = Identifier::CreateWith([
           'Token'=>Token::CreateWith(['Type'=>TokenType::IDENT,'Literal'=>'myVar']) ,
            'Value'=>'myVar' ,
        ]);

        $value = Identifier::CreateWith([
            'Token' => Token::CreateWith(['Type' => TokenType::IDENT, 'Literal' => 'anotherVar']),
            'Value' => 'anotherVar',
        ]);

        $letStatement->Token = $token ;
        $letStatement->Name = $name ;
        $letStatement->Value = $value ;

        $statements[] = $letStatement ;

        $program->Statements = $statements ;

        $this->assertEquals($program->String(),"let myVar = anotherVar;",
            sprintf("program.String() wrong. got=%s", $program->String())
            );
    }

}