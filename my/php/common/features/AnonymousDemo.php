<?php

namespace my\php\common\features;

use my\php\common\features\_1\two;
use year\db\DynamicActiveRecord;
use function my\php\common\features\_1\create;

/**
 * @see https://www.php.net/manual/en/language.oop5.anonymous.php
 */
class AnonymousDemo
{
    public static function run()
    {
        static::demo1(); return ;

//        DynamicActiveRecord::setDbID('db');
//        DynamicActiveRecord::setTableName('some_table');
        $anotherDAR = returnDynamicActiveRecord() ;
        $anotherDARClass = get_class($anotherDAR) ;

        var_dump($anotherDARClass);

        $creator = returnDynamicActiveRecordCreator();
        $d2 = $creator();
        dump($d2);
        dump($creator()) ;
        dump([
           $creator(),
//           $creator(),
//            get_class($creator()),
            get_class($creator()),
            get_class(returnDynamicActiveRecord()),
        ]);
        if (get_class($creator()) === get_class(returnDynamicActiveRecordCreator()())) {
            echo 'same class';
        } else {
            echo 'different class';
        }
    }
    protected static function demo1()
    {
        $newTwoObj = create(new two());
        dump($newTwoObj) ;
    }

}
// function create(SomeInterface $obj)
//{
//    $class = get_class($obj);
//    return new class extends $class {
//    //some magic here
//    }
//}

function returnDynamicActiveRecord(){
    return new class extends DynamicActiveRecord{
    };
}

/**
 * @return \Closure
 */
function returnDynamicActiveRecordCreator(){
   // Arrow functions are shorter than anonymous functions, and use the parent scope
    return function (){
        return new class extends DynamicActiveRecord {
        };

    } ;

}


/**
 * @return __anonymous@1395
 */
function somethingHaveMyTrait()
{
    return (new class() {
        use MyTrait;
    });
}

/**
 *
 */
trait MyTrait
{
    /**
     * @return string
     */
    public function foo(): string
    {
        return 'foo';
    }
}

  namespace my\php\common\features\_1;
// https://stackoverflow.com/questions/42960114/php-anonymous-class-extends-dynamic
  interface SomeInterface {};
  class one implements SomeInterface {};
  class two extends one {};

  function create(SomeInterface $class) {
      $className = get_class($class);
      return eval("return (new class() extends $className {});");
  }



