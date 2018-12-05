<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/12/5
 * Time: 14:54
 */

trait MetaTrait
{

    private $methods = array();

    public function addMethod($methodName, $methodCallable)
    {
        if (!is_callable($methodCallable)) {
            throw new InvalidArgumentException('Second param must be callable');
        }
        $this->methods[$methodName] = Closure::bind($methodCallable, $this, get_class());
    }

    public function __call($methodName, array $args)
    {
        if (isset($this->methods[$methodName])) {
            return call_user_func_array($this->methods[$methodName], $args);
        }

        throw RunTimeException('There is no method with the given name to call');
    }

}

/**
 * @param \Closure $callable
 *
 * @return bool
 */
function isBindable(\Closure $callable)
{
    $bindable = false;

    $reflectionFunction = new \ReflectionFunction($callable);
    if (
        $reflectionFunction->getClosureScopeClass() === null
        || $reflectionFunction->getClosureThis() !== null
    ) {
        $bindable = true;
    }

    return $bindable;
}

/**
 *          ##  测试下方法绑定
 */

class BaseObject{
    public $name = 'obj10';

    public function doSomething()
    {
        echo 'hi i come from'. get_class($this) ;
        echo "\n my name is {$this->name}";
    }
}

$obj = new BaseObject() ;
$obj->doSomething() ;

$rc = new ReflectionClass($obj) ;
$closure = $rc->getMethod('doSomething')->getClosure( $obj ) ; // getClosure() ;

class Foo{
    public $name = '20' ;
}

$foo = new Foo() ;

/*
$c2 = $closure->bindTo($foo);

$closure() ;
echo "call c2 \n";
$c2() ;
*/

$obj2 = new BaseObject() ;
$obj2->name = 'obj2 ya ' ;

echo $closure->call($obj2) ;