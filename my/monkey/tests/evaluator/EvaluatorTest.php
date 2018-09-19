<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/4
 * Time: 15:59
 */

namespace yiiunit\extensions\monkey\evaluator;


use monkey\evaluator\Evaluator;
use monkey\object\Boolean;
use monkey\object\Environment;
use monkey\object\Error;
use monkey\object\Func;
use monkey\object\Integer;
use monkey\object\Object;
use monkey\parser\Parser;
use yiiunit\extensions\monkey\TestCase;

class EvaluatorTest extends TestCase
{
    public function testEvalIntegerExpression()
    {
        $tests = [
            ["5", 5],
            ["10", 10],
            ["-5", -5],
            ["-10", -10],
            ["5 + 5 + 5 + 5 - 10", 10],
            ["2 * 2 * 2 * 2 * 2", 32],
            ["-50 + 100 + -50", 0],
            ["5 * 2 + 10", 20],
            ["5 + 2 * 10", 25],
            ["20 + 2 * -10", 0],
            ["50 / 2 * 2 + 10", 60],
            ["2 * (5 + 10)", 30],
            ["3 * 3 * 3 + 10", 37],
            ["3 * (3 * 3) + 10", 37],
            ["(5 + 10 * 2 + 15 / 3) * 2 + -10", 50],
        ];

        foreach ($tests as $_ => $tt) {
            $evaluated = $this->_testEval($tt[0]);
            $this->_testIntegerObject($evaluated, $tt[1]);
        }
    }

    public function testEvalBooleanExpression()
    {
        $tests = [
            ['true', true],
            ['false', false],

            ["1 < 2", true],
            ["1 > 2", false],
            ["1 < 1", false],
            ["1 > 1", false],
            ["1 == 1", true],
            ["1 != 1", false],
            ["1 == 2", false],
            ["1 != 2", true],

            ["true == true", true],
            ["false == false", true],
            ["true == false", false],
            ["true != false", true],
            ["false != true", true],
            ["(1 < 2) == true", true],
            ["(1 < 2) == false", false],
            ["(1 > 2) == true", false],
            ["(1 > 2) == false", true],
        ];

        foreach ($tests as $_ => $tt) {
            $evaluated = $this->_testEval($tt[0]);
            // var_dump($evaluated) ;
            // die(__METHOD__) ;
            $this->_testBooleanObject($evaluated, $tt[1]);
        }
    }

    public function testIfElseExpression()
    {
        $tests = [
            ["if (true) { 10 }", 10],
            ["if (false) { 10 }", null],
            ["if (1) { 10 }", 10],
            ["if (1 < 2) { 10 }", 10],
            ["if (1 > 2) { 10 }", null],
            ["if (1 > 2) { 10 } else { 20 }", 20],
            ["if (1 < 2) { 10 } else { 20 }", 10],
        ];

        foreach ($tests as $_ => $tt) {
            $evaluated = $this->_testEval($tt[0]);
            $integer = $tt[1];
            $type = gettype($integer);
            if ($type == 'integer') {
                $this->_testIntegerObject($evaluated, $integer);
            } else {
                $this->_testNullObject($evaluated);
            }
        }
    }

    public function testReturnStatements()
    {
        $tests = [
            ["return 10;", 10],
            ["return 10; 9;", 10],
            ["return 2 * 5; 9;", 10],
            ["9; return 2 * 5; 9;", 10],
        ];

        foreach ($tests as $_ => $tt) {
            $evaluated = $this->_testEval($tt[0]);
            $this->_testIntegerObject($evaluated, $tt[1]);
        }
    }

    /**
     * @param \monkey\object\Object $obj
     * @return bool
     */
    protected function _testNullObject($obj): bool
    {
        if ($obj != Evaluator::$NULL) {
            $this->assertTrue(false,
                sprintf("object is not NULL. got=%s (%s)", gettype($obj), $obj)
            );
            return false;
        }
        return true;
    }

    public function testBangOperator()
    {
        $tests = [
            ["!true", false],
            ["!false", true],
            ["!5", false],
            ["!!true", true],
            ["!!false", false],
            ["!!5", true],
        ];

        foreach ($tests as $_ => $tt) {
            $evaluated = $this->_testEval($tt[0]);
            $this->_testBooleanObject($evaluated, $tt[1]);
        }
    }

    public function testFunctionObject()
    {
        $input = "fn(x) { x + 2; };";
        $evaluated = $this->_testEval($input);
        $this->assertInstanceOf(Func::class, $evaluated,
            sprintf("object is not Function. got=%s (%s)", gettype($evaluated),var_export($evaluated,true))
        );
        $fn = $evaluated ;
        // 欺骗IDE 让它给智能提示！！！
        if($fn instanceof  Func){}

        $this->assertCount(1, $fn->Parameters
            , sprintf("function has wrong parameters. Parameters=%d",
                count($fn->Parameters))
        );

        $this->assertEquals($fn->Parameters[0]->String(), 'x',
            sprintf("parameter is not 'x'. got=%s",
                var_export($fn->Parameters[0] ,true) )
        );

         $expectedBody = "(x + 2)";
        $this->assertEquals($fn->Body->String(), $expectedBody,
            sprintf("body is not %s. got=%s",
                $expectedBody,
                var_export($fn->Body->String() ,true) )
        );
    }

    /**
     * @param string $input
     * @return Object
     */
    protected function _testEval($input) // :Object
    {
        $l = \monkey\lexer\Lexer::NewLexer($input);
        $p = Parser::NewParser($l);
        $program = $p->ParseProgram();
        $env = Environment::NewEnvironment();

        return Evaluator::DoEval($program, $env);
    }

    /**
     * @param Object $obj
     * @param int $expected
     * @return bool
     */
    protected function _testIntegerObject(Object $obj, $expected = 0): bool
    {
        $result = $obj;
        if (!$obj instanceof Integer) {
            $this->assertTrue(false,
                sprintf("object is not Integer. got=%s (%s)", gettype($obj), var_export($obj,true))
            );
            return false;
        }
        if ($result->Value != $expected) {
            $this->assertTrue(false,
                sprintf("object has wrong value. got=%d, want=%d",
                    $result->Value, $expected)
            );
            return false;
        }

        return true;
    }

    /**
     * @param Object $obj
     * @param int $expected
     * @return bool
     */
    protected function _testBooleanObject(Object $obj, $expected = 0): bool
    {
        $result = $obj;
        if (!$obj instanceof Boolean) {
            $this->assertTrue(false,
                sprintf("object is not Boolean. got=%s (%s)", gettype($obj), $obj)
            );
            return false;
        }
        if ($result->Value != $expected) {
            $this->assertTrue(false,
                sprintf("object has wrong value. got=%s, want=%s",
                    $result->Value, $expected)
            );
            return false;
        }

        return true;
    }

    public function testErrorHandling()
    {
        $tests = [
            [
                "5 + true;",
                "type mismatch: INTEGER + BOOLEAN",
            ],
            [
                "5 + true; 5;",
                "type mismatch: INTEGER + BOOLEAN",
            ],
            [
                "-true",
                "unknown operator: -BOOLEAN",
            ],
            [
                "true + false;",
                "unknown operator: BOOLEAN + BOOLEAN",
            ],
            [
                "5; true + false; 5",
                "unknown operator: BOOLEAN + BOOLEAN",
            ],
            [
                "if (10 > 1) {true + false; }",
                "unknown operator: BOOLEAN + BOOLEAN",
            ],
            [
                "if (10 > 1) {
if (10 > 1) {
return true + false;
}
return 1;
}",
                "unknown operator: BOOLEAN + BOOLEAN",
            ],
            [
                "foobar",
                "identifier not found: foobar",
            ]
        ];

        foreach ($tests as $_ => $tt) {
            $evaluated = $this->_testEval($tt[0]);

            $errObj = $evaluated;
            if (!$errObj instanceof Error) {
                $this->assertTrue(false,
                    sprintf("no error object returned. got=%s(%s)", gettype($errObj), var_export($errObj, true))
                );
                continue;
            }
            $this->assertEquals($errObj->Message, $tt[1],
                sprintf("wrong error message. expected=%s, got=%s",
                    $tt[1], $errObj->Message)
            );
        }
    }

    public function testLetStatements()
    {
        $tests = [
            ["let a = 5; a;", 5],
            ["let a = 5 * 5; a;", 25],
            ["let a = 5; let b = a; b;", 5],
            ["let a = 5; let b = a; let c = a + b + 5; c;", 15],
        ];

        foreach ($tests as $_ => $tt) {
            $this->_testIntegerObject($this->_testEval($tt[0]), $tt[1]);
        }
    }

    public function testFunctionApplication()
    {
        $tests = [
            ["let identity = fn(x) { x; }; identity(5);", 5],
            ["let identity = fn(x) { return x; }; identity(5);", 5],
            ["let double = fn(x) { x * 2; }; double(5);", 10],
            ["let add = fn(x, y) { x + y; }; add(5, 5);", 10],
            ["let add = fn(x, y) { x + y; }; add(5 + 5, add(5, 5));", 20],
            ["fn(x) { x; }(5)", 5],
        ];

        foreach ($tests as $_=>$tt){
            $this->_testIntegerObject($this->_testEval($tt[0]),$tt[1]);
        }
    }

    public function testClosures()
    {
        $input = <<<INPUT
let newAdder = fn(x) {
fn(y) { x + y };
};
let addTwo = newAdder(2);
addTwo(2);
INPUT;
          $this->_testIntegerObject($this->_testEval($input),4);

    }
}