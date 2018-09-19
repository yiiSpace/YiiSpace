<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/30
 * Time: 7:32
 */

namespace yiiunit\extensions\monkey\parser;


use monkey\ast\Boolean;
use monkey\ast\CallExpression;
use monkey\ast\Expression;
use monkey\ast\ExpressionStatement;
use monkey\ast\FunctionLiteral;
use monkey\ast\Identifier;
use monkey\ast\IfExpression;
use monkey\ast\InfixExpression;
use monkey\ast\IntegerLiteral;
use monkey\ast\PrefixExpression;
use monkey\ast\ReturnStatement;
use monkey\ast\Statement;
use monkey\ast\LetStatement;
use monkey\lexer\Lexer;
use monkey\parser\Parser;
use yiiunit\extensions\monkey\TestCase;

// use PHPUnit\Framework\TestCase ;

/**
 * @see https://phpunit.de/manual/current/en/appendixes.assertions.html#appendixes.assertions.assertEquals
 * 所有的assertXxx 方法 都可以添加最后一个message 消息参数！
 * Class ParserTest
 * @package yiiunit\extensions\monkey\parser
 */
class ParserTest extends TestCase
{

    public function testLetStatements()
    {
        $input = <<<IN
let x = 5;
let y = 10;
let foobar = 838383;
IN;

        $l = Lexer::NewLexer($input);
        $p = Parser::NewParser($l);

        $program = $p->ParseProgram();
        $this->assertNotNull($program);

        $this->assertEquals(count($program->Statements), 3);

        $tests = [
            ['x'],
            ['y'],
            ['foobar'],
        ];

        foreach ($tests as $i => $tt) {
            $stmt = $program->Statements[$i];
            $this->_testLetStatement($stmt, $tt[0]);
        }

    }

    public function testLetStatements2()
    {
        $input = <<<IN
let x =5;
let y = 10;
let foobar = 838383;
IN;

        $l = Lexer::NewLexer($input);
        $p = Parser::NewParser($l);

        $program = $p->ParseProgram();
        $this->checkParserErrors($p);

        $this->assertNotNull($program);

        $this->assertEquals(count($program->Statements), 3);

        $tests = [
            ['x'],
            ['y'],
            ['foobar'],
        ];

        foreach ($tests as $i => $tt) {
            $stmt = $program->Statements[$i];
            $this->_testLetStatement($stmt, $tt[0]);
        }

    }

    public function testLetStatements3()
    {
        $tests = [
            ["let x = 5;", "x", 5],
            ["let y = true;", "y", true],
            ["let foobar = y", "foobar", "y"],
        ];

        foreach ($tests as $i => $tt) {
            $input = $tt[0];
            $l = Lexer::NewLexer($input);
            $p = Parser::NewParser($l);

            $program = $p->ParseProgram();
            $this->checkParserErrors($p);

            $this->assertCount(1, $program->Statements
                , sprintf("program.Statements does not contain 3 statements. got=%d",
                    count($program->Statements))
            );

            $stmt = $program->Statements[0];
            if (!$this->_testLetStatement($stmt, $tt[1])) {
                return;
            }
            $val = $stmt->Value;
            if (!$this->_testLiteralExpression($val, $tt[2])) {
                return;
            }
        }


    }

    /**
     *  测试输出相等！
     */
    public function testExpectFooActualFoo()
    {
        $this->expectOutputString('foo');
        print 'foo';
    }

    protected function checkParserErrors(Parser $p)
    {
        $errors = $p->Errors();
        if (count($errors) == 0) {
            return;
        }

        // $this->assertEquals(count($errors),0);
        // $this->assertEmpty($errors ,sprintf("parser has %d errors", count($errors)));
        // print_r($errors) ;
        $this->assertCount(0, $errors, print_r($errors, true));
        foreach ($errors as $i => $error) {
            // echo '$i = '.$i , PHP_EOL;
            $this->assertEmpty($error, "parser error: {$error}");
        }

    }

    /**
     * @param Statement $s
     * @param string $name
     * @return bool
     */
    protected function _testLetStatement(Statement $s, string $name)
    {
        $this->assertEquals($s->TokenLiteral(), 'let');
        if ($s instanceof LetStatement) {
            $this->assertInstanceOf(LetStatement::class, $s);

            $this->assertEquals($s->Name->Value, $name);

            $this->assertEquals($s->Name->TokenLiteral(), $name);
        }
    }

    public function testReturnStatement()
    {
        $input = <<<IN
return 5;
return 10;
return 993322;
IN;

        $l = Lexer::NewLexer($input);
        $p = Parser::NewParser($l);

        $program = $p->ParseProgram();
        $this->checkParserErrors($p);

        $this->assertCount(3, $program->Statements
            , sprintf("program.Statements does not contain 3 statements. got=%d",
                count($program->Statements))
        );

        foreach ($program->Statements as $i => $stmt) {
            $this->assertInstanceOf(ReturnStatement::class, $stmt,
                sprintf("stmt not *ast.returnStatement. got=%s", gettype($stmt))
            );
            $this->assertEquals($stmt->TokenLiteral(), 'return',
                sprintf("returnStmt.TokenLiteral not 'return', got %s",
                    $stmt->TokenLiteral())
            );
        }

    }

    public function testIdentifierExpression()
    {
        $input = <<<IN
foobar;
IN;

        $l = Lexer::NewLexer($input);
        $p = Parser::NewParser($l);

        $program = $p->ParseProgram();
        $this->checkParserErrors($p);

        $this->assertCount(1, $program->Statements
            , sprintf("program.Statements does not contain 1 statements. got=%d",
                count($program->Statements))
        );

        $stmt = $program->Statements[0];
        $this->assertInstanceOf(ExpressionStatement::class, $stmt,
            sprintf("stmt not ExpressionStatement. got=%s", gettype($stmt))
        );
        $ident = $stmt->Expression;
        $this->assertInstanceOf(Identifier::class, $ident,
            sprintf("stmt not Identifier. got=%s", gettype($ident))
        );

        $this->assertEquals($ident->Value, 'foobar',
            sprintf("ident.Value not %s. got=%s",
                'foobar', $ident->Value)
        );

        $this->assertEquals($ident->TokenLiteral(), 'foobar',
            sprintf("ident.TokenLiteral not %s. got=%s",
                "foobar", $ident->TokenLiteral())
        );
    }

    public function testIntegerExpression()
    {
        $input = <<<IN
5;
IN;

        $l = Lexer::NewLexer($input);
        $p = Parser::NewParser($l);

        $program = $p->ParseProgram();
        $this->checkParserErrors($p);

        $this->assertCount(1, $program->Statements
            , sprintf("program.Statements does not contain 1 statements. got=%d",
                count($program->Statements))
        );

        $stmt = $program->Statements[0];
        $this->assertInstanceOf(ExpressionStatement::class, $stmt,
            sprintf("stmt not ExpressionStatement. got=%s", gettype($stmt))
        );
        $literal = $stmt->Expression;
        $this->assertInstanceOf(IntegerLiteral::class, $literal,
            sprintf("stmt not Identifier. got=%s", gettype($literal))
        );

        $this->assertEquals($literal->Value, '5',
            sprintf("literal.Value not %d. got=%d",
                5, $literal->Value)
        );
        if ($literal instanceof IntegerLiteral) {
            //  var_dump($literal);
            // var_dump($literal->TokenLiteral()) ;
        }

        $this->assertEquals($literal->TokenLiteral(), '5',
            sprintf("ident.TokenLiteral not %s. got=%s",
                "5", $literal->TokenLiteral())
        );
    }

    public function testBooleanExpression()
    {
        $input = <<<IN
true
IN;

        $l = Lexer::NewLexer($input);
        $p = Parser::NewParser($l);

        $program = $p->ParseProgram();
        $this->checkParserErrors($p);

        $this->assertCount(1, $program->Statements
            , sprintf("program.Statements does not contain 1 statements. got=%d",
                count($program->Statements))
        );

        $stmt = $program->Statements[0];
        $this->assertInstanceOf(ExpressionStatement::class, $stmt,
            sprintf("stmt not ExpressionStatement. got=%s", gettype($stmt))
        );
        $literal = $stmt->Expression;
        $this->assertInstanceOf(Boolean::class, $literal,
            sprintf("stmt not Boolean. got=%s", gettype($literal))
        );

        /*
        $this->assertEquals($literal->Value, '5',
            sprintf("literal.Value not %d. got=%d",
                5, $literal->Value)
        );
        if ($literal instanceof Boolean) {
            //  var_dump($literal);
            // var_dump($literal->TokenLiteral()) ;
        }

        $this->assertEquals($literal->TokenLiteral(), '5',
            sprintf("ident.TokenLiteral not %s. got=%s",
                "5", $literal->TokenLiteral())
        );
        */
    }

    public function testParsingPrefixExpression()
    {
        $prefixTests = [
            ['!5', '!', 5],
            ['-15', '-', 15],

            ["!true;", "!", true],
            ["!false;", "!", false],
        ];

        foreach ($prefixTests as $i => $tt) {
            $input = $tt[0];

            $l = Lexer::NewLexer($input);
            $p = Parser::NewParser($l);

            $program = $p->ParseProgram();
            $this->checkParserErrors($p);

            $this->assertCount(1, $program->Statements
                , sprintf("program.Statements does not contain 1 statements. got=%d",
                    count($program->Statements))
            );

            $stmt = $program->Statements[0];
            $this->assertInstanceOf(ExpressionStatement::class, $stmt,
                sprintf("stmt not ExpressionStatement. got=%s", gettype($stmt))
            );

            $exp = $stmt->Expression;
            $this->assertInstanceOf(PrefixExpression::class, $exp,
                sprintf("stmt is not PrefixExpression. got=%s", gettype($stmt))
            );

            $this->assertEquals($exp->Operator, $tt[1],
                sprintf("exp.Operator is not %s. got=%s",
                    $tt[1], $exp->Operator)
            );
            /*
            if (!$this->_testIntegerLiteral($exp->Right, $tt[2])) {
                return;
            }
            */
            if (!$this->_testLiteralExpression($exp->Right, $tt[2])) {
                return;
            }
        }
    }

    public function testParsingInfixExpression()
    {
        $infixTests = [
            ["5 + 5;", 5, "+", 5],
            ["5 - 5;", 5, "-", 5],
            ["5 * 5;", 5, "*", 5],
            ["5 / 5;", 5, "/", 5],
            ["5 > 5;", 5, ">", 5],
            ["5 < 5;", 5, "<", 5],
            ["5 == 5;", 5, "==", 5],
            ["5 != 5;", 5, "!=", 5],

            ["true == true", true, "==", true],
            ["true != false", true, "!=", false],
            ["false == false", false, "==", false],
        ];

        foreach ($infixTests as $i => $tt) {
            $input = $tt[0];

            $l = Lexer::NewLexer($input);
            $p = Parser::NewParser($l);

            $program = $p->ParseProgram();
            $this->checkParserErrors($p);

            $this->assertCount(1, $program->Statements
                , sprintf("program.Statements does not contain 1 statements. got=%d",
                    count($program->Statements))
            );

            $stmt = $program->Statements[0];
            $this->assertInstanceOf(ExpressionStatement::class, $stmt,
                sprintf("stmt not ExpressionStatement. got=%s", gettype($stmt))
            );

            $exp = $stmt->Expression;
            $this->assertInstanceOf(InfixExpression::class, $exp,
                sprintf("stmt is not InfixExpression. got=%s", gettype($stmt->Expression))
            );

            if (!$this->_testLiteralExpression($exp->Left, $tt[1])) {
                return;
            }
            if (!$this->_testLiteralExpression($exp->Right, $tt[3])) {
                return;
            }
            /*
            if (!$this->_testIntegerLiteral($exp->Left, $tt[1])) {
                return;
            }
            $this->assertEquals($exp->Operator, $tt[2],
                sprintf("exp.Operator is not %s. got=%s",
                    $tt[2], $exp->Operator)
            );
            if (!$this->_testIntegerLiteral($exp->Right, $tt[3])) {
                return;
            }
            */
        }
    }

    public function testOperatorPrecedenceParsing()
    {
        $tests = [
            [
                "-a * b",
                "((-a) * b)",
            ],
            [
                "!-a",
                "(!(-a))",
            ],
            [
                "a + b + c",
                "((a + b) + c)",
            ],
            [
                "a + b - c",
                "((a + b) - c)",
            ],
            [
                "a * b * c",
                "((a * b) * c)",
            ],
            [
                "a * b / c",
                "((a * b) / c)",
            ],
            [
                "a + b / c",
                "(a + (b / c))",
            ],
            [
                "a + b * c + d / e - f",
                "(((a + (b * c)) + (d / e)) - f)",
            ],
            [
                "3 + 4; -5 * 5",
                "(3 + 4)((-5) * 5)",
            ],
            [
                "5 > 4 == 3 < 4",
                "((5 > 4) == (3 < 4))",
            ],
            [
                "5 < 4 != 3 > 4",
                "((5 < 4) != (3 > 4))",
            ],
            [
                "3 + 4 * 5 == 3 * 1 + 4 * 5",
                "((3 + (4 * 5)) == ((3 * 1) + (4 * 5)))",],
            [
                "3 + 4 * 5 == 3 * 1 + 4 * 5",
                "((3 + (4 * 5)) == ((3 * 1) + (4 * 5)))",
            ],

            [
                "true",
                "true",
            ],
            [
                "false",
                "false",
            ],
            [
                "3 > 5 == false",
                "((3 > 5) == false)",
            ],
            [
                "3 < 5 == true",
                "((3 < 5) == true)",
            ],

            [
                "1 + (2 + 3) + 4",
                "((1 + (2 + 3)) + 4)",
            ],
            [
                "(5 + 5) * 2",
                "((5 + 5) * 2)",
            ],
            [
                "2 / (5 + 5)",
                "(2 / (5 + 5))",
            ],
            [
                "-(5 + 5)",
                "(-(5 + 5))",
            ],
            [
                "!(true == true)",
                "(!(true == true))",
            ],

            [
                "a + add(b * c) + d",
                "((a + add((b * c))) + d)",
            ],
            [
                "add(a, b, 1, 2 * 3, 4 + 5, add(6, 7 * 8))",
                "add(a, b, 1, (2 * 3), (4 + 5), add(6, (7 * 8)))",
            ],
            [
                "add(a + b + c * d / f + g)",
                "add((((a + b) + ((c * d) / f)) + g))",
            ],
        ];

        foreach ($tests as $i => $tt) {
            $input = $tt[0];
            $l = Lexer::NewLexer($input);
            $p = Parser::NewParser($l);
            $program = $p->ParseProgram();
            $this->checkParserErrors($p);

            $actual = $program->String();

            $this->assertTrue($actual == $tt[1],
                sprintf("expected=%q, got=%q", $tt[1], $actual)
            );
        }

    }

    public function testIfExpression()
    {
        $input = <<<IN
if (x < y) { x } 
IN;
        $l = Lexer::NewLexer($input);
        $p = Parser::NewParser($l);
        $program = $p->ParseProgram();
        $this->checkParserErrors($p);

        $this->assertCount(1, $program->Statements
            , sprintf("program.Statements does not contain 1 statements. got=%d",
                count($program->Statements))
        );

        $stmt = $program->Statements[0];
        $this->assertInstanceOf(ExpressionStatement::class, $stmt,
            sprintf("stmt not ExpressionStatement. got=%s", gettype($stmt))
        );

        $exp = $stmt->Expression;
        $this->assertInstanceOf(IfExpression::class, $exp,
            sprintf("stmt is not IfExpression. got=%s", gettype($stmt->Expression))
        );
        if (!$this->_testInfixExpression($exp->Condition, "x", '<', 'y')) {
            return;
        }
        if (count($exp->Consequence->Statements) != 1) {
            $this->assertTrue(false,
                sprintf("consequence is not 1 statements. got=%d\n", count($exp->Consequence->Statements))
            );
        }
        $consequence = $exp->Consequence->Statements[0];
        // var_dump($exp->Consequence) ;
        $this->assertInstanceOf(ExpressionStatement::class, $consequence,
            sprintf("Statements[0] is not ast.ExpressionStatement. got=%s", gettype($exp->Consequence->Statements[0]))
        );
        if (!$this->_testIdentifier($consequence->Expression, 'x')) {
            return;
        }
        /*
        // $this->assertNotEmpty($stack);
        $this->assertNotNull($exp->Alternative,
            sprintf("exp.Alternative.Statements was not nil. got=%s", var_export($exp->Alternative,true))
            );
        */

    }

    public function testIfElseExpression()
    {
        $input = <<<IN
if (x < y) { x } else{ y }
IN;
        $l = Lexer::NewLexer($input);
        $p = Parser::NewParser($l);
        $program = $p->ParseProgram();
        $this->checkParserErrors($p);

        $this->assertCount(1, $program->Statements
            , sprintf("program.Statements does not contain 1 statements. got=%d",
                count($program->Statements))
        );

        $stmt = $program->Statements[0];
        $this->assertInstanceOf(ExpressionStatement::class, $stmt,
            sprintf("stmt not ExpressionStatement. got=%s", gettype($stmt))
        );

        $exp = $stmt->Expression;
        $this->assertInstanceOf(IfExpression::class, $exp,
            sprintf("stmt is not IfExpression. got=%s", gettype($stmt->Expression))
        );
        if (!$this->_testInfixExpression($exp->Condition, "x", '<', 'y')) {
            return;
        }
        if (count($exp->Consequence->Statements) != 1) {
            $this->assertTrue(false,
                sprintf("consequence is not 1 statements. got=%d\n", count($exp->Consequence->Statements))
            );
        }
        $consequence = $exp->Consequence->Statements[0];
        // var_dump($exp->Consequence) ;
        $this->assertInstanceOf(ExpressionStatement::class, $consequence,
            sprintf("Statements[0] is not ast.ExpressionStatement. got=%s", gettype($exp->Consequence->Statements[0]))
        );
        if (!$this->_testIdentifier($consequence->Expression, 'x')) {
            return;
        }
        // $this->assertNotEmpty($stack);
        $this->assertNotNull($exp->Alternative,
            sprintf("exp.Alternative.Statements was not nil. got=%s", var_export($exp->Alternative, true))
        );

    }



    public function testFunctionLiteralParsing()
    {
        $input = <<<IN
fn(x, y) { x + y; }
IN;
        $l = Lexer::NewLexer($input);
        $p = Parser::NewParser($l);
        $program = $p->ParseProgram();
        $this->checkParserErrors($p);

        $this->assertCount(1, $program->Statements
            , sprintf("program.Statements does not contain 1 statements. got=%d",
                count($program->Statements))
        );

        $stmt = $program->Statements[0];
        $this->assertInstanceOf(ExpressionStatement::class, $stmt,
            sprintf("stmt not ExpressionStatement. got=%s", gettype($stmt))
        );

        // 函数字面量特有的情况
        $function = $stmt->Expression;
        $this->assertInstanceOf(FunctionLiteral::class, $function,
            sprintf("stmt.Expression is not ast.FunctionLiteral. got=%s", gettype($function))
        );

        $this->assertCount(2, $function->Parameters,
            sprintf("function literal parameters wrong. want 2, got=%d\n",
                count($function->Parameters))
        );

        $this->_testLiteralExpression($function->Parameters[0], 'x');
        $this->_testLiteralExpression($function->Parameters[1], 'y');

        $this->assertCount(1, $function->Body->Statements,
            sprintf("function.Body.Statements has not 1 statements. got=%d\n",
                count($function->Body->Statements))
        );

        $bodyStmt = $function->Body->Statements[0];
        $this->assertInstanceOf(ExpressionStatement::class, $bodyStmt,
            sprintf("function body stmt is not ast.ExpressionStatement. got=%T", gettype($bodyStmt))
        );

        $this->_testInfixExpression($bodyStmt->Expression, 'x', '+', 'y');

    }

    public function testFunctionParameterParsing()
    {
        $tests = [
            ['input' => "fn() {};", 'expectedParams' => []],
            ['input' => "fn(x){}", 'expectedParams' => ["x"]],
            ['input' => "fn(x, y, z) {}", 'expectedParams' => ["x", "y", "z"]],
        ];

        foreach ($tests as $i => $tt) {
            $l = Lexer::NewLexer($tt['input']);
            $p = Parser::NewParser($l);
            $program = $p->ParseProgram();
            $this->checkParserErrors($p);

            $stmt = $program->Statements[0];
            $function = $stmt->Expression;

            $this->assertEquals(count($function->Parameters), count($tt['expectedParams']),
                sprintf("length parameters wrong. want %d, got=%d\n",
                    count($tt['expectedParams']), count($function->Parameters))
            );

            foreach ($tt['expectedParams'] as $i => $ident) {
                $this->_testLiteralExpression($function->Parameters[$i], $ident);
            }
        }
    }

    public function testCallExpressionParsing()
    {
        $input = <<<INPUT
add(1, 2 * 3, 4 + 5);
INPUT;

        $l = Lexer::NewLexer($input);
        $p = Parser::NewParser($l);
        $program = $p->ParseProgram();
        $this->checkParserErrors($p);

        $this->assertCount(1, $program->Statements
            , sprintf("program.Statements does not contain 1 statements. got=%d",
                count($program->Statements))
        );

        $stmt = $program->Statements[0];
        $this->assertInstanceOf(ExpressionStatement::class, $stmt,
            sprintf("stmt not ExpressionStatement. got=%s", gettype($stmt))
        );

        // 特有测试
        $exp = $stmt->Expression;
        $this->assertInstanceOf(CallExpression::class, $exp,
            sprintf("stmt.Expression is not ast.CallExpression. got=%s", gettype($exp))
        );
        if (!$this->_testIdentifier($exp->Function, 'add')) {
            return;
        }
        $this->assertCount(3, $exp->Arguments
            , sprintf("wrong length of arguments. got=%d",
                count($exp->Arguments))
        );

        $this->_testLiteralExpression($exp->Arguments[0], 1);
        $this->_testInfixExpression($exp->Arguments[1], 2, '*', 3);
        $this->_testInfixExpression($exp->Arguments[2], 4, '+', 5);

    }

    /**
     * @param Expression $il integerLiteral
     * @param int $value
     * @return bool
     */
    protected function _testIntegerLiteral(Expression $il, $value = 0): bool
    {
        $integ = $il;
        $this->assertInstanceOf(IntegerLiteral::class, $il,
            sprintf("il is not IntegerLiteral. got=%s", gettype($il))
        );
        if (!$il instanceof IntegerLiteral) {
            return false;
        }

        $this->assertEquals($integ->Value, $value,
            sprintf("integ.Value is not %d. got=%d",
                $value, $integ->Value)
        );

        if ($integ->TokenLiteral() != sprintf("%d", $value)) {
            $this->assertTrue(false,
                sprintf("integ.TokenLiteral not %d. got=%s", $value,
                    $integ->TokenLiteral())
            );
            return false;
        }

        return true;
    }

    /**
     * @param Expression $exp
     * @param string $value
     * @return bool
     */
    protected function _testIdentifier(Expression $exp, $value = ''): bool
    {
        $ident = $exp;
        $this->assertInstanceOf(Identifier::class, $exp,
            sprintf("exp is not Identifier. got=%s", gettype($exp))
        );

        if ($ident instanceof Identifier) {
            if ($ident->Value != $value) {
                $this->assertTrue(false,
                    sprintf("ident.Value not %s. got=%s", $value,
                        $ident->Value)
                );
                return false;
            }

            if ($ident->TokenLiteral() != $value) {
                $this->assertTrue(false,
                    sprintf("ident.TokenLiteral not %s. got=%s", $value,
                        $ident->TokenLiteral())
                );
                return false;
            }

        }
        return true;
    }

    /**
     * @param Expression $exp
     * @param $excepted
     * @return bool
     */
    protected function _testLiteralExpression(
        Expression $exp,
        $excepted
    ): bool
    {

        switch (gettype($excepted)) {
            case 'int':
            case 'integer':
                return $this->_testIntegerLiteral($exp, $excepted);
            case 'string':
                return $this->_testIdentifier($exp, $excepted);
            case 'bool':
            case 'boolean':
                return $this->_testBooleanLiteral($exp, $excepted);
        }
        $this->assertTrue(false,
            sprintf("type of exp not handled. got=%s", gettype($excepted))
        );
        return false;
    }

    /**
     * @param Expression $exp
     * @param $left
     * @param $operator
     * @param $right
     * @return bool
     */
    protected function _testInfixExpression(Expression $exp, $left, $operator, $right): bool
    {
        $opExp = $exp;
        $this->assertInstanceOf(InfixExpression::class, $exp,
            sprintf("exp is not InfixExpression. got=%s(%s)", gettype($exp), $exp->String())
        );
        if (!$this->_testLiteralExpression($opExp->Left, $left)) {
            return false;
        }

        if ($opExp->Operator != $operator) {
            $this->assertFlase(true,
                sprintf("exp.Operator is not '%s'. got=%s", $operator, $opExp->Operator)
            );
            return false;
        }

        if (!$this->_testLiteralExpression($opExp->Right, $right)) {
            return false;
        }
        return true;

    }

    /**
     * @param Expression $exp
     * @param bool $value
     * @return bool
     */
    protected function _testBooleanLiteral(Expression $exp, bool $value): bool
    {
        $bo = $exp;
        $this->assertInstanceOf(Boolean::class, $exp,
            sprintf("exp is not Boolean. got=%s(%s)", gettype($exp), $exp->String())
        );

        if ($bo->Value != $value) {
            // $this->assertFalse(true,
            $this->assertTrue(false,
                sprintf("bo.Value is not '%s'. got=%s", $value, $bo->Value)
            );
            return false;
        }
        /*
        var_dump($bo) ;

        if ($bo->TokenLiteral() != sprintf('%s', gettype($value))) {
           // $this->assertFlase(true,
            $this->assertTrue(false,
                sprintf("bo.TokenLiteral not %s. got=%s", gettype($value), $bo->TokenLiteral())
            );
            return false;
        }
        */

        return true;

    }
}