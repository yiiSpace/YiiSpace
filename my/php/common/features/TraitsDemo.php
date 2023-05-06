<?php
// @see  http://php.net/language.oop5.traits
// @see https://www.yii666.com/blog/105411.html
// @see https://www.tabangni.com/phpstudy/6207.html
namespace my\php\common\features {

    use function _2\run;

    class TraitsDemo
    {
        public static function run()
        {
            echo 'hi' . __METHOD__;

            $c = new C();
            echo $c->var1;
            echo $c->var2;

            $c->methodA();
            $c->methodB();

            dump($c);

            run();
            // trait 中有同名函数时可以使用 insteadof 表示使用使用那个方法代替
            \_collision\run();
            \_attributes\run();
        }
    }

    trait A
    {
        /**
         * Undocumented variable
         *
         * @var string
         */
        public $var1 = 'var1_from_A';

        public function methodA()
        {
            echo '' . __METHOD__;
        }

    }

    trait B
    {
        public $var2 = 'var2_from_B';

        public function methodB()
        {
            echo '' . __METHOD__;
        }
    }

    class C
    {
        use A, B;
    }


}

// 名空间 另一种形式是 分号分割 如同往常那样声明 即多个namespace声明同时存在 所属区间如同地界那样
// 不带名称的名空间 即是global名空间
namespace _2 {


    trait A
    {
        public $var1 = 'var1_of_A';

        public function test()
        {
            echo __NAMESPACE__ . __METHOD__, PHP_EOL;
        }

        public function test1()
        {
            echo __NAMESPACE__ . __METHOD__, PHP_EOL;
        }
    }

    class B
    {
        public function test()
        {
            echo __NAMESPACE__ . __METHOD__, PHP_EOL;
        }

        public function test1()
        {
            echo __NAMESPACE__ . __METHOD__, PHP_EOL;
        }
    }

    class C extends B
    {
        use A;

        public function test()
        {
            echo __NAMESPACE__ . __METHOD__, PHP_EOL;
        }
    }

    function run()
    {

        $c = new C();
        $c->test(); //c::test()
        print_r("</br>");
        $c->test1(); //A::test1()
    }

}

namespace _collision {
    trait A
    {
        public function test()
        {
            echo 'A::test()';
        }
    }

    trait B
    {
        public function test()
        {
            echo 'B::test()';
        }
    }

    class C
    {
        use A, B {
            B::test insteadof A;
            B::test as t;
        }
    }

    function run()
    {
        $c = new C();
        $c->test(); //B::test()
        $c->t(); //B::test()  可以用as另起名

    }
}

namespace _modify_priviliage {
    // use 是一种依赖方向 被依赖者除的方法如果是public 那么 权限可以as为 protected｜private
    // 这符合直觉 ：底层是全开放的 上层可以遮盖底层接口 或者窄化它 。如果底层是protected 的那么上层是否可以public它呢 ，宽化
    trait HelloWorld
    {
        public function sayHello()
        {
            echo 'Hello World!';
        }
    }

    // 修改 sayHello 的访问控制
    class A
    {
        use HelloWorld {
            sayHello as protected;
        }
    }

    // 给方法一个改变了访问控制的别名
// 原版 sayHello 的访问控制则没有发生变化
    class B
    {
        use HelloWorld {
            sayHello as private myPrivateHello;
        }
    }

    function run()
    {

        $b = new A();
        //        $b->sayHello(); //Fatal error: Call to protected method A::sayHello() from context ''

    }

}

namespace _nested_traits {
    trait A
    {
        public function test1()
        {
            echo 'test1';
        }
    }

    trait B
    {
        public function test2()
        {
            echo 'test2';
        }
    }

    trait C
    {
        use A, B;
    }

    class D
    {
        use C;
    }

    function run()
    {
        $d = new D();
        $d->test2(); //test2

    }
}

namespace _abstract_method {
    trait A
    {
        public function test1()
        {
            static $a = 0;
            $a++;
            echo $a;
        }

        // 充当抽象类的角色
        abstract public function test2(); //可定义抽象方法
    }

    class B
    {
        use A;

        public function test2()
        {

        }
    }

    function run()
    {

        $b = new B();
        $b->test1(); //1
        $b->test1(); //2
    }
}

namespace _attributes {
    trait A
    {

        private $var = 'p_a';
        protected $var2 = 'f_a';
        public $test1;
    }

    class B
    {
        use A;

        public $test2;
    }

    function run()
    {
        $b = new B();
//          $b->$var2 = 'hi';
        $b->test1 = 'set value to trait a';
//          var_dump($b);
        dump($b);
    }
}

namespace _priority {
    // precedence

    class Base
    {
        public function foo()
        {
            echo 'foo from base';
        }
    }

    trait HasFoo
    {
        public function foo()
        {
            // 这就要求使用者的父类需要拥有foo方法
            parent::foo();
            echo ' after parent::foo', PHP_EOL;
        }
    }

    class Bar extends Base
    {
        use HasFoo;
    }

    function run()
    {
        $bar = new Bar();
        // 这个方法是调用trait的方法的
        $bar->foo();
    }
}

namespace _static_attribute_method {
    trait Counter
    {
        public function inc()
        {
            static $c = 0;
            $c = $c + 1;
            echo "$c \n";
        }
    }

    class C1
    {
        use Counter;
    }

    class C2
    {
        use Counter;
    }

    function run()
    {
        $c1 = new C1();
        $c2 = new C2();

        $c1->inc();
        $c2->inc();

        Helper::someFunc();
    }

    trait BaseHelper
    {
        public static function someFunc()
        {
            return __METHOD__;
        }
    }

    class Helper
    {
        use BaseHelper;
    }
}

namespace _statics {
    trait Counter
    {
        public static $c = 0;

        public static function inc()
        {
            self::$c = self::$c + 1;
            echo self::$c . "\n";
        }
    }

    class C1
    {
        use Counter;
    }

    class C2
    {
        use Counter;
    }

    function run()
    {
        C1::inc();
        C2::inc();
    }
}

namespace _trait_name {
    trait TestTrait
    {
        public function testMethod()
        {
            echo "Class: " . __CLASS__ . PHP_EOL;
            echo "Trait: " . __TRAIT__ . PHP_EOL;
        }
    }

    class BaseClass
    {
        use TestTrait;
    }

    class TestClass extends BaseClass
    {
    }

    function run()
    {
        $t = new TestClass();
        $t->testMethod();
//Class: BaseClass
//Trait: TestTrait
    }
}

namespace _singleton{
    trait singleton {
        /**
         * private construct, generally defined by using class
         */
        //private function __construct() {}
        public static function getInstance() {
            static $_instance = NULL;
            $class = __CLASS__;
            return $_instance ?: $_instance = new $class;
        }
        public function __clone() {
            trigger_error('Cloning '.__CLASS__.' is not allowed.',E_USER_ERROR);
        }
        public function __wakeup() {
            trigger_error('Unserializing '.__CLASS__.' is not allowed.',E_USER_ERROR);
        }
    }

    class Foo{
        use singleton;

        /**
         * @var string
         */
        protected $name ;
        private function __construct() {
            $this->name = 'foo';
        }
    }
}

namespace _call_trait_method{


    trait Foo {
        function bar() {
            return 'baz';
        }
    }

   function run(){
        Foo::bar();
    }
}