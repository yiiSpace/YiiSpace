<?php

namespace my\php\common\features;

/*
 * @see https://www.tutorialspoint.com/generator-return-expressions-in-php-7
 * @see https://alanastorm.com/php-generators-from-scratch/
 *
 * - generators are for building iterators.
 * - Generators are a special type of function in PHP that always returns a Generator object.
 * - they were just a fancy version of the goto statement.
 *
 * 注意rust中的future 内部就是用generator实现的 但两个语言中的generator是否是同一概念就有待研究了！
 *
 * 其他
 *  https://www.php.net/manual/en/generator.throw.php
 *  https://www.php.net/manual/en/generator.send.php
 * https://www.php.net/manual/en/language.generators.syntax.php
 *
 * 更多其他知识：https://alanastorm.com/category/modern_php/
 */

use function _2\handleIteratorInForeach;
use function _2\similarToReturn;
use function _3\rangeDemo;

class GeneratorDemo
{

    static public function run()
    {
//        simple();
        returnExpressionsDemo2();
        returnOrYield();

        yieldAsReturn();

        similarToReturn();
        handleIteratorInForeach();

        rangeDemo();
        static::anonymousClassDemo();
        static::yieldWithKey();
    }

    static protected function anonymousClassDemo()
    {
        $generator = function ()
        {
            $i = 0 ;
          while ($i< 3){
              yield new class extends GeneratorDemo {

              };
              $i ++ ; // 少了这个 就成死循环了 😄
          }
        };
        $g = $generator();

        foreach ($g as $obj)
        {
            // 匿名类的对象总是同一个！而不是不同的类🥱
            dump( get_class($obj)) ;
        }
    }

    static protected function yieldWithKey()
    {
        function Generator() {
            yield 'key1' => 'val 1';
            yield 'key2' => 'val 2';
            yield 'key3' => 'val 3';
        }

        $gen = Generator();
        foreach ($gen as $k => $v) {
            echo "$k => $v\n";
        }
    }


    static protected function customRange()
    {
        $range = function ($start , $end){
          for($i=$start ; $i<= $end; $i++){
            yield $i ;
          }
        };

        foreach($range(1,PHP_INT_MAX) as $val){
            echo "current val: {$val}" ;
        }

    }

    /**
     * https://iwconnect.com/understanding-php-generators-memory-performance/
     *
     * @return void
     */
    static protected function SendingValues2Generator()
    {
        $range = function ($start , $end){
            for($i=$start ; $i<= $end; $i++){
               $input =  yield $i ;

               if($input === 'break'){
                   return ;
               }
            }
        };

        $generator = $range(1,PHP_INT_MAX)  ;
        foreach( $generator as $val){
            echo "current val: {$val}" ;
            if($val === 5){
                $generator->send('break') ;
            }
        }
    }

    static protected function returnValuesFromGenerator()
    {
        $genFunc = function (){
          yield 1 ;
          yield 2 ;
          return "return result: ". 3*3 ;
        };
        $generator = $genFunc() ;
        foreach ($generator as $value){
            dump($value) ;
        }

        // 获取return 值
        dump($generator->getReturn()) ;
    }
}

function simple()
{
    $generator = (function () {
        yield "five";
        yield "six";
        yield "seven";
        return "eight";
    })
    ();
    foreach ($generator as $val) {
        echo $val, PHP_EOL;
    }
    echo $generator->getReturn(), PHP_EOL;
}

function returnExpressionsDemo2()
{
    function gen()
    {
        yield 'A';
        yield 'B';
        yield 'C';
        return 'gen-return';
    }

    $generator = gen();
    var_dump($generator);
    foreach ($generator as $letter) {
        echo $letter;
    }
    var_dump($generator->getReturn());
}

/**
 * @return void
 *
 * PHP will always treat a function that includes the yield keyword as a generator function,
 * and a generator function will always return a Generator object.
 */
function returnOrYield()
{
    function myGeneratorFunction()
    {
        yield;
    }

    $returnValue = myGeneratorFunction();
    echo get_class($returnValue), "\n";
}

/**
 * Generator objects are PHP iterators
 *
 * @return void
 */
function areIterators()
{
    $values = [1, 2, 3, 4, 5];
// using foreach
    foreach ($values as $number) {
        echo $number, "\n";
    }

// using an iterator
    $iterator = new ArrayIterator($values);
    while ($number = $iterator->current()) {
        echo $number, "\n";
        $iterator->next();
    }

}

/**
 * the yield keyword tells PHP to pause the current function execution and return a value to the generator/iterator object.
 * This happens the first time the generator’s current method is called.
 * When an end-user-programmer calls the generator object’s next function,
 * PHP will return to the generator function and continue execution immediately after the point that yield was called
 *
 * @return void
 *
 *   yield‘s power to pause a function
 *
 */
function yieldAsReturn()
{
    $myGeneratorFunction = function /* myGeneratorFunction*/ () {
        echo "One", "\n";
        yield 'first return value';

        echo "Two", "\n";
        yield 'second return value';

        echo "Three", "\n";
        yield 'third return value';
    };

    // get our Generator object (remember, all generator function return
// a generator object, and a generator function is any function that
// uses the yield keyword)
    $iterator = $myGeneratorFunction();

// get the current value of the iterator
    $value = $iterator->current();

    // get the next value of the iterator
    $value = $iterator->next();

// and the value after that the next value of the iterator
    $value = $iterator->next();
}

namespace _2;
/**
 * In addition to pausing a function — the yield keyword also returns a value that the generator/iterator object will know to use as the current value.
 *
 * @return void
 */
function similarToReturn()
{
    function myGeneratorFunction()
    {
        echo "One", "\n";
        yield 'first return value';

        echo "Two", "\n";
        yield 'second return value';

        echo "Three", "\n";
        yield 'third return value';
    }

// get our Generator object (remember, all generator function return
// a generator object, and a generator function is any function that
// uses the yield keyword)
    $iterator = myGeneratorFunction();

// get the current value of the iterator
    $value = $iterator->current();
    echo 'The value returned: ', $value, "\n";

// get the next value of the iterator
    $iterator->next();
    $value = $iterator->current();
    echo 'The value returned: ', $value, "\n";

// and the value after that the next value of the iterator
    $iterator->next();
    $value = $iterator->current();
    echo 'The value returned: ', $value, "\n";
}

/**
 * Under the hood, when you use an iterator object in a foreach loop,
 * PHP is making the same calls to that iterator’s next and current methods.
 *
 * @return void
 */
function handleIteratorInForeach()
{
    /** @var \Generator $myGeneratorFunction */
    $myGeneratorFunction = function/* myGeneratorFunction*/ () {
        yield 'first return value';
        yield 'second return value';
        yield 'third return value';
    };

    $generator = $myGeneratorFunction();
    foreach ($generator as $value) {
        echo 'My Value Is: ', $value, "\n";
    }
}

namespace _3;

function rangeDemo()
{
    # 1. Define a Generator Function
    function generator_range($min, $max)
    {
        #3b. Start executing once `current`'s been called
        for ($i = $min; $i <= $max; $i++) {
            echo "Starting Loop", "\n";
            yield $i;   #3c. Return execution to the main program
            #4b. Return execution to the main program again
            #4a. Resume exection when `next is called
            echo "Ending Loop", "\n";
        }
    }

#2. Call the generator function
    $generator = generator_range(1, 5);

#3a. Call the `current` method on the generator function
    echo $generator->current(), "\n";

#4a. Resume execution and call `next` on the generator object
    $generator->next();

#5 echo out value we yielded when calling `next` above
    echo $generator->current(), "\n";

// give this a try when you have some free time
// foreach(generator_range(1, 5) as $value) {
//    echo $value, "\n";
// }
}

