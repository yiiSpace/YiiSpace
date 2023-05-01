<?php
// @see https://www.yii666.com/blog/105411.html
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

namespace _attributes{
    trait A {

        private $var = 'p_a';
        protected $var2 = 'f_a';
        public $test1;
      }
       
      class B {
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