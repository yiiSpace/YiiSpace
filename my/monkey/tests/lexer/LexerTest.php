<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/28
 * Time: 11:36
 */

namespace yiiunit\extensions\monkey\lexer;

use yiiunit\extensions\monkey\TestCase;

use monkey\lexer\Lexer;
use monkey\token\TokenType;


class LexerTest extends TestCase
{
    public function _testNextToken()
    {
        $input = <<<IN
=+(){},;
IN;
        /**
         * expectedType token.TokenType
         * expectedLiteral string
         */
        $tests = [
            [TokenType::ASSIGN, "="],
            [TokenType::PLUS, "+"],
            [TokenType::LPAREN, "("],
            [TokenType::RPAREN, ")"],
            [TokenType::LBRACE, "{"],
            [TokenType::RBRACE, "}"],
            [TokenType::COMMA, ","],
            [TokenType::SEMICOLON, ";"],
            [TokenType::EOF, ""],
        ];

        $l = Lexer::NewLexer($input);


        foreach ($tests as $i => $tt) {
            $tok = $l->NextToken();
            /*
            print_r([
               'type'=>$tok->Type,
               'literal'=>$tok->Literal,
            ]);
            printf("%s  =>  %s \n ",$tt[0],$tt[1]) ;
            */
            // var_dump($tok) ; // die();
            $this->assertEquals($tok->Type, $tt[0]);
            $this->assertEquals($tok->Literal, $tt[1]);

        }
    }

    /**
     *
     */
    public function _testSpace()
    {
        $input = <<<DOC

    INPUTsome;
some string  
DOC;
        $pos = 0;
        $stop = false;
        for ($i = 0; !$stop; $i++) {
            $ch = $input[$i];
            // var_dump($ch) ;
            if (  /*in_array($ch,[' ','\r','\n','\t'])*/
                preg_match('|\s|', $ch) == 1) {

            } else {
                $stop = true;
                $pos = $i;
            }
        }
        // var_dump( substr($input,$pos) );
    }


    public function testNextToken2()
    {
        $input = <<<IN
let five = 5;
let ten = 10;
let add = fn(x, y) {
    x+y;
};
let result = add(five, ten);
IN;

        /*  $input = "let five = 5 " ;


           /**
            * expectedType token.TokenType
            * expectedLiteral string
            */
        $tests = [
            [TokenType::LET, "let"],
            [TokenType::IDENT, "five"],
            [TokenType::ASSIGN, "="],
            [TokenType::INT, "5"],

            [TokenType::SEMICOLON, ";"],

            [TokenType::LET, "let"],
            [TokenType::IDENT, "ten"],
            [TokenType::ASSIGN, "="],
            [TokenType::INT, "10"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::LET, "let"],
            [TokenType::IDENT, "add"],
            [TokenType::ASSIGN, "="],
            [TokenType::FUNCTION, "fn"],
            [TokenType::LPAREN, "("],
            [TokenType::IDENT, "x"],
            [TokenType::COMMA, ","],
            [TokenType::IDENT, "y"],
            [TokenType::RPAREN, ")"],

            [TokenType::LBRACE, "{"],
            [TokenType::IDENT, "x"],
            [TokenType::PLUS, "+"],
            [TokenType::IDENT, "y"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::RBRACE, "}"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::LET, "let"],
            [TokenType::IDENT, "result"],
            [TokenType::ASSIGN, "="],
            [TokenType::IDENT, "add"],
            [TokenType::LPAREN, "("],
            [TokenType::IDENT, "five"],
            [TokenType::COMMA, ","],
            [TokenType::IDENT, "ten"],
            [TokenType::RPAREN, ")"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::EOF, ""],
        ];

        $l = Lexer::NewLexer($input);


        foreach ($tests as $i => $tt) {
            $tok = $l->NextToken();

            /*
            print_r([
               'type'=>$tok->Type,
               'literal'=>$tok->Literal,
            ]);
            printf("%s  =>  %s \n ",$tt[0],$tt[1]) ;
            */
            // var_dump($tok) ; // die();
            $this->assertEquals($tok->Type, $tt[0]);
            $this->assertEquals($tok->Literal, $tt[1]);

        }
    }

    public function testNextToken3()
    {
        $input = <<<IN
let five = 5;
let ten = 10;
let add = fn(x, y) {
	x + y;
};
let result = add(five, ten);
!-/*5;
5 < 10 > 5;
if (5 < 10) {
	return true;
} else {
	return false;
}
10 == 10;
10 != 9;
"foobar"
"foo bar"
[1, 2];
{"foo": "bar"}
IN;

        /*
         $input = "let five = 5;" ;


           /**
            * expectedType token.TokenType
            * expectedLiteral string
            */
        $tests = [
            [TokenType::LET, "let"],
            [TokenType::IDENT, "five"],
            [TokenType::ASSIGN, "="],
            [TokenType::INT, "5"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::LET, "let"],
            [TokenType::IDENT, "ten"],
            [TokenType::ASSIGN, "="],
            [TokenType::INT, "10"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::LET, "let"],
            [TokenType::IDENT, "add"],
            [TokenType::ASSIGN, "="],
            [TokenType::FUNCTION, "fn"],
            [TokenType::LPAREN, "("],
            [TokenType::IDENT, "x"],
            [TokenType::COMMA, ","],
            [TokenType::IDENT, "y"],
            [TokenType::RPAREN, ")"],
            [TokenType::LBRACE, "{"],
            [TokenType::IDENT, "x"],
            [TokenType::PLUS, "+"],
            [TokenType::IDENT, "y"],

            [TokenType::SEMICOLON, ";"],
            [TokenType::RBRACE, "}"],

            [TokenType::SEMICOLON, ";"],

            [TokenType::LET, "let"],
            [TokenType::IDENT, "result"],
            [TokenType::ASSIGN, "="],
            [TokenType::IDENT, "add"],
            [TokenType::LPAREN, "("],
            [TokenType::IDENT, "five"],
            [TokenType::COMMA, ","],
            [TokenType::IDENT, "ten"],
            [TokenType::RPAREN, ")"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::BANG, "!"],
            [TokenType::MINUS, "-"],
            [TokenType::SLASH, "/"],
            [TokenType::ASTERISK, "*"],
            [TokenType::INT, "5"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::INT, "5"],
            [TokenType::LT, "<"],
            [TokenType::INT, "10"],
            [TokenType::GT, ">"],
            [TokenType::INT, "5"],
            [TokenType::SEMICOLON, ";"],

            [TokenType::IF, "if"],
            [TokenType::LPAREN, "("],
            [TokenType::INT, "5"],
            [TokenType::LT, "<"],
            [TokenType::INT, "10"],
            [TokenType::RPAREN, ")"],
            [TokenType::LBRACE, "{"],
            [TokenType::RETURN, "return"],
            [TokenType::TRUE, "true"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::RBRACE, "}"],
            [TokenType::ELSE, "else"],
            [TokenType::LBRACE, "{"],
            [TokenType::RETURN, "return"],
            [TokenType::FALSE, "false"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::RBRACE, "}"],

            [TokenType::INT, "10"],
            [TokenType::EQ, "=="],
            [TokenType::INT, "10"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::INT, "10"],
            [TokenType::NOT_EQ, "!="],
            [TokenType::INT, "9"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::STRING, "foobar"],
            [TokenType::STRING, "foo bar"],
            [TokenType::LBRAKET, "["],
            [TokenType::INT, "1"],
            [TokenType::COMMA, ","],
            [TokenType::INT, "2"],
            [TokenType::RBRAKET, "]"],
            [TokenType::SEMICOLON, ";"],

            [TokenType::LBRACE, "{"],
            [TokenType::STRING, "foo"],
            [TokenType::COLON, ":"],
            [TokenType::STRING, "bar"],
            [TokenType::RBRACE, "}"],

            [TokenType::EOF, ""],

        ];

        $l = Lexer::NewLexer($input);


        foreach ($tests as $i => $tt) {
            $tok = $l->NextToken();

            /*
            print_r([
               'type'=>$tok->Type,
               'literal'=>$tok->Literal,
            ]);
            printf("%s  =>  %s \n ",$tt[0],$tt[1]) ;
            */
            // var_dump($tok) ; // die();
            $this->assertEquals($tok->Type, $tt[0]);
            $this->assertEquals($tok->Literal, $tt[1]);

        }
    }

}