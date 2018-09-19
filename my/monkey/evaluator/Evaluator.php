<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/4
 * Time: 15:58
 */

namespace monkey\evaluator;


use monkey\ast\BlockStatement;
use monkey\ast\CallExpression;
use monkey\ast\Expression;
use monkey\ast\ExpressionStatement;
use monkey\ast\FunctionLiteral;
use monkey\ast\Identifier;
use monkey\ast\IfExpression;
use monkey\ast\InfixExpression;
use monkey\ast\IntegerLiteral;
use monkey\ast\LetStatement;
use monkey\ast\Node;
use monkey\ast\PrefixExpression;
use monkey\ast\Program;
use monkey\ast\ReturnStatement;
use monkey\ast\Statement;
use monkey\object\Boolean;
use monkey\object\Environment;
use monkey\object\Error;
use monkey\object\Func;
use monkey\object\Integer;
use monkey\object\Nil;
use monkey\object\Object;
use monkey\object\ObjectType;
use monkey\object\ReturnValue;

//use monkey\object\Object;


class Evaluator
{
    /**
     * @var Boolean
     */
    public static $TRUE;

    /**
     * @var Boolean
     */
    public static $FALSE;

    /**
     * @var Nil
     */
    public static $NULL;
    /*
    protected static function InitBooleans()
    {
        self::$TRUE = Boolean::CreateWith([
            'Value' => true,
        ]);
        self::$FALSE = Boolean::CreateWith([
            'Value' => false,
        ]);
    }
    */

    /**
     * @param Node $node
     * @param Environment $env
     * @return Object
     */
    public static function DoEval(Node $node, Environment $env) // :Object
    {
        switch (true) {

            case $node instanceof Program:
                return self::evalProgram($node, $env);

            case $node instanceof ExpressionStatement:
                return self::DoEval($node->Expression, $env);

            case $node instanceof IntegerLiteral :
                return Integer::CreateWith([
                    'Value' => $node->Value,
                ]);

            case $node instanceof \monkey\ast\Boolean:
                /*
                return Boolean::CreateWith([
                    'Value' => $node->Value,
                ]);
                */
                return static::nativeBoolToBooleanObject($node->Value);

            case $node instanceof PrefixExpression:
                $right = static::DoEval($node->Right, $env);
                if (static::isError($right)) {
                    return $right;
                }
                return static::evalPrefixExpression($node->Operator, $right);

            case $node instanceof InfixExpression:
                $left = static::DoEval($node->Left, $env);
                if (static::isError($left)) {
                    return $left;
                }
                $right = static::DoEval($node->Right, $env);
                if (static::isError($right)) {
                    return $right;
                }
                return static::evalInfixExpression($node->Operator, $left, $right);

            case $node instanceof BlockStatement:
                return static::evalBlockStatement($node, $env);
            case $node instanceof IfExpression:
                return static::evalIfExpression($node, $env);

            case  $node instanceof ReturnStatement:
                $val = static::DoEval($node->ReturnValue, $env);
                if (static::isError($val)) {
                    return $val;
                }
                return ReturnValue::CreateWith(['Value' => $val]);

            case $node instanceof LetStatement:
                $val = static::DoEval($node->Value, $env);
                if (static::isError($val)) {
                    return $val;
                }
                return $env->Set($node->Name->Value, $val);

            case $node instanceof Identifier:
                return static::evalIdentifier($node, $env);

            case $node instanceof FunctionLiteral:
                $params = $node->Parameters ;
                $body  = $node->Body ;
                return Func::CreateWith([
                   'Parameters'=>$params ,
                   'Env'=>$env,
                    'Body'=>$body ,
                ]);
            case $node instanceof CallExpression:
                $function = static::DoEval($node->Function, $env);
                if (static::isError($function)) {
                    return $function;
                }
                $args = static::evalExpressions($node->Arguments, $env);
                if (count($args) == 1 && static::isError($args[0])) {
                    return $args[0];
                }
                return static::applyFunction($function, $args);
        }
        return null;
    }

    /**
     * @param  Object $fn
     * @param  Object[] $args
     * @return Object
     */
    protected static function applyFunction($fn, $args) // :Object
    {
        $function = $fn;
        if (!$function instanceof Func) {
            return static::newError("not a function: %s", $fn->Type());
        }
        $extendedEnv = static::extendFunctionEnv($function, $args);
        $evaluated = static::DoEval($function->Body, $extendedEnv);
        return static::unwrapReturnValue($evaluated);
    }

    /**
     * @param Func $fn
     * @param Object[] $args
     * @return Environment
     */
    protected static function extendFunctionEnv($fn,$args):Environment
    {
        $env = Environment::NewEnclosedEnvironment($fn->Env);

        foreach ($fn->Parameters as $paramIdx => $param){
            $env->Set($param->Value,$args[$paramIdx]) ;
        }
        return $env ;
    }

    /**
     * @param Object $obj
     * @return Object
     */
    protected static function unwrapReturnValue($obj) // :Object
    {
        if($obj instanceof  ReturnValue){
            return $obj->Value ;
        }
        return $obj ;
    }

    /**
     * @param array|Expression[] $exps
     * @param Environment $env
     * @return \monkey\object\Object[]
     */
    protected static function evalExpressions(
        array $exps,
        Environment $env
    )// :array
    {
        $result = [];
        foreach ($exps as $_ => $exp) {
            $evaluated = static::DoEval($exp, $env);
            if (static::isError($evaluated)) {
                return [$evaluated];
            }
            $result[] = $evaluated;
        }
        return $result;
    }

    /**
     * @param $input
     * @return Boolean
     */
    protected static function nativeBoolToBooleanObject($input): Boolean
    {
        if ($input) {
            return static::$TRUE;
        }
        return static::$FALSE;
    }

    /**
     * @param IfExpression $ie
     * @return \monkey\object\Object
     */
    protected static function evalIfExpression($ie, Environment $env) // :Object
    {
        $condition = static::DoEval($ie->Condition, $env);

        if (static::isError($condition)) {
            return $condition;
        }

        if (static::isTruthy($condition)) {
            return static::DoEval($ie->Consequence, $env);
        } elseif ($ie->Alternative != null) {
            return static::DoEval($ie->Alternative, $env);
        } else {
            return static::$NULL;
        }
    }

    /**
     * @param \monkey\object\Object $obj
     * @return bool
     */
    protected static function isTruthy($obj): bool
    {
        switch ($obj) {
            case static::$NULL:
                return false;
            case static::$TRUE:
                return true;
            case static::$FALSE:
                return false;
            default:
                return true;
        }
    }

    /**
     * @param array|Statement[] $stmts
     * @return Object
     */
    public static function evalStatements($stmts = []) // : Object
    {
        /** @var Object $result */
        $result = static::$NULL;

        foreach ($stmts as $stmt) {
            $result = static::DoEval($stmt);
            if ($result instanceof ReturnValue) {
                return $result->Value;
            }
        }

        return $result;
    }

    /**
     * @param Program $program
     * @param Environment $env
     * @return Nil|Object
     */
    public static function evalProgram(Program $program, Environment $env) // : Object
    {
        /** @var Object $result */
        $result = static::$NULL;

        foreach ($program->Statements as $_ => $statement) {
            $result = static::DoEval($statement, $env);

            /*
            if ($result instanceof ReturnValue) {
                return $result->Value;
            }
            */
            switch (true) {
                case $result instanceof ReturnValue:
                    return $result->Value;
                case $result instanceof Error:
                    return $result;
            }
        }

        return $result;
    }

    /**
     * @param Identifier $node
     * @param Environment $env
     * @return \monkey\object\Object
     */
    protected static function evalIdentifier(Identifier $node, Environment $env) // :Object
    {
        if (!$env->Exists($node->Value)) {
            return static::newError("identifier not found: " . $node->Value);
        }
        $val = $env->Get($node->Value);
        return $val;
    }

    /**
     * @param BlockStatement $block
     * @param Environment $env
     * @return Object
     */
    protected static function evalBlockStatement(BlockStatement $block, Environment $env)// :Object
    {
        /** @var  \monkey\object\Object $result */
        $result = null;
        foreach ($block->Statements as $statement) {
            $result = static::DoEval($statement, $env);
            /*
            if ($result != null && $result->Type() == ObjectType::RETURN_VALUE_OBJ) {
                return $result;
            }
            */
            if ($result != null) {
                $rt = $result->Type();
                if ($rt == ObjectType::RETURN_VALUE_OBJ || $rt == ObjectType::ERROR_OBJ) {
                    return $result;
                }
            }
        }
        return $result;
    }

    /**
     * @param string $operator
     * @param Object $right
     * @return Object|null
     */
    protected static function evalPrefixExpression($operator = '', $right) // :Object
    {
        switch ($operator) {
            case '!':
                return static::evalBangOperatorExpression($right);
            case '-':
                return static::evalMinusPrefixOperatorExpression($right);
            /*
             default:
                 return self::$NULL;
            */
            default:
                return static::newError("unknown operator: %s%s", $operator, $right->Type());
        }
    }

    /**
     * @param string $operator
     * @param \monkey\object\Object $left
     * @param \monkey\object\Object $right
     * @return \monkey\object\Object
     */
    protected static function evalInfixExpression($operator = '', $left, $right) // :Object
    {
        switch (true) {
            case $left->Type() == ObjectType::INTEGER_OBJ && $right->Type() == ObjectType::INTEGER_OBJ:
                return static::evalIntegerInfixExpression($operator, $left, $right);
            case $operator == '==':
                return static::nativeBoolToBooleanObject($left == $right);
            case $operator == '!=':
                return static::nativeBoolToBooleanObject($left != $right);
            /*
           default:
               return static::$NULL;
            */
            case $left->Type() != $right->Type():
                return static::newError("type mismatch: %s %s %s",
                    $left->Type(), $operator, $right->Type());
            default:
                return static::newError("unknown operator: %s %s %s",
                    $left->Type(), $operator, $right->Type());
        }
    }

    /**
     * @param string $operator
     * @param \monkey\object\Object $left
     * @param \monkey\object\Object $right
     * @return \monkey\object\Object
     */
    protected static function evalIntegerInfixExpression($operator = '', $left, $right)
    {
        $leftVal = $left->Value;
        $rightVal = $right->Value;

        switch ($operator) {
            case '+':
                return Integer::CreateWith(['Value' => $leftVal + $rightVal]);
            case '-':
                return Integer::CreateWith(['Value' => $leftVal - $rightVal]);
            case '*':
                return Integer::CreateWith(['Value' => $leftVal * $rightVal]);
            case '/':
                return Integer::CreateWith(['Value' => $leftVal / $rightVal]);

            case '<':
                return static::nativeBoolToBooleanObject($leftVal < $rightVal);
            case '>':
                return static::nativeBoolToBooleanObject($leftVal > $rightVal);
            case '==':
                return static::nativeBoolToBooleanObject($leftVal == $rightVal);
            case '!=':
                return static::nativeBoolToBooleanObject($leftVal != $rightVal);

            default:
                // return static::$NULL;
                return static::newError("unknown operator: %s %s %s",
                    $left->Type(), $operator, $right->Type());
        }
    }

    /**
     * @TODO 搞清楚php中的 ==  在左右值是对象时的行为（对比指针？）
     *
     * @param Object $right
     * @return Object
     */
    protected static function evalBangOperatorExpression(Object $right) // :Object
    {
        switch ($right) {
            case static::$TRUE:
                return static::$FALSE;
            case static::$FALSE:
                return static::$TRUE;
            case static::$NULL:
                return static::$TRUE;
            default:
                return static::$FALSE;
        }
    }

    /**
     * @param \monkey\object\Object $right
     * @return Object
     */
    protected static function evalMinusPrefixOperatorExpression($right) // :Object
    {
        if ($right->Type() != ObjectType::INTEGER_OBJ) {
            //  return static::$NULL;
            return static::newError("unknown operator: -%s", $right->Type());
        }
        if ($right instanceof Integer) {
            $value = $right->Value;
            return Integer::CreateWith([
                'Value' => -$value
            ]);
        }

    }

    /**
     * @param string $format
     * @param array ...$a 始于php5.6 开始支持可变函数参数 内部用数组形式引用 ;在函数调用时候 也可以用此形式 ...$params 展开参数列表
     * @return Error
     */
    protected static function newError(string $format = '', ...$a): Error
    {
        // $p = array_unshift($a,$format) ;
        return Error::CreateWith([
            'Message' => sprintf($format, ...$a)// call_user_func_array('sprintf',$a) // sprintf($format,$a)
        ]);
    }

    /**
     * @param \monkey\object\Object $obj
     * @return bool
     */
    protected static function isError($obj): bool
    {
        if ($obj != null) {
            return $obj->Type() == ObjectType::ERROR_OBJ;
        }
        return false;
    }
}

(function () {
    // 只实例化一次
    // if (isset(Evaluator::$TRUE)) return;

    Evaluator::$TRUE = Boolean::CreateWith([
        'Value' => true,
    ]);
    Evaluator::$FALSE = Boolean::CreateWith([
        'Value' => false,
    ]);

    Evaluator::$NULL = Nil::CreateWith();
})();

// InitBooleans();
