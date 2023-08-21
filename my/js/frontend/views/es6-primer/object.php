<?php

use common\widgets\ViewInfo;
use macgyer\yii2materializecss\widgets\Modal;
use yii\helpers\Inflector;

/**   @var \yii\web\View $this  /
/**    @var string $content  */

// 注册js｜css 所需的asset
$asset = \common\widgets\PrismAsset::register($this);
?>

<?php $this->beginBlock('my-es-code'); ?>
<script>
    // 简单例子🌰  
    console.log(Object);

    /** ## 简写 属性｜方法都可以简写 */
    {
        {
            const foo = 'bar';
            const baz = {
                foo
            };

        }
        // 方法简写
        {
            const o = {
                method() {
                    return "Hello!";
                }
            };

            // 等同于

            const _o = {
                method: function() {
                    return "Hello!";
                }
            };

        }
        // 实际例子 
        {
            let birth = '2000/01/01';

            const Person = {

                name: '张三',

                //等同于birth: birth
                birth,

                // 等同于hello: function ()...
                hello() {
                    console.log('我的名字是', this.name);
                }

            };

        }
        // setter/getter
        {
            const cart = {
                _wheels: 4,

                get wheels() {
                    return this._wheels;
                },

                set wheels(value) {
                    if (value < this._wheels) {
                        throw new Error('数值太小了！');
                    }
                    this._wheels = value;
                }
            }

        }


        // 注意，简写的对象方法不能用作构造函数，会报错。
        {

            const obj = {
                f() {
                    this.foo = 'bar';
                }
            };

            // new obj.f() // 报错

        }
    }

    /** ## 属性名表达式 */
    {
        let propKey = 'foo';

        let obj = {
            [propKey]: true,
            ['a' + 'bc']: 123
        };

    }
    // 定义方法名
    {
        let obj = {
            ['h' + 'ello']() {
                return 'hi';
            }
        };

        obj.hello() // hi

    }

    // ## 方法的name属性
    {
        const person = {
            sayName() {
                console.log('hello!');
            },
        };

        person.sayName.name // "sayName"


    }
    // getter|setter 
    {
        const obj = {
            get foo() {},
            set foo(x) {}
        };

        // obj.foo.name
        // TypeError: Cannot read property 'name' of undefined

        const descriptor = Object.getOwnPropertyDescriptor(obj, 'foo');

        descriptor.get.name // "get foo"
        descriptor.set.name // "set foo"

    }
    // symbol值
    {
        const key1 = Symbol('description');
        const key2 = Symbol();
        let obj = {
            [key1]() {},
            [key2]() {},
        };
        obj[key1].name // "[description]"
        obj[key2].name // ""

    }
    /** ## 属性的可枚举性和遍历 */
    {
        let obj = {
            foo: 123
        };
        Object.getOwnPropertyDescriptor(obj, 'foo')
        //  {
        //    value: 123,
        //    writable: true,
        //    enumerable: true,
        //    configurable: true
        //  }
        /**
         * 目前，有四个操作会忽略enumerable为false的属性。

            for...in循环：只遍历对象自身的和继承的可枚举的属性。
            Object.keys()：返回对象自身的所有可枚举的属性的键名。
            JSON.stringify()：只串行化对象自身的可枚举的属性。
            Object.assign()： 忽略enumerable为false的属性，只拷贝对象自身的可枚举的属性。

         * 引入“可枚举”（enumerable）这个概念的最初目的，就是让某些属性可以规避掉for...in操作，不然所有内部属性和方法都会被遍历到
         */
        Object.getOwnPropertyDescriptor(Object.prototype, 'toString').enumerable
        // false

        Object.getOwnPropertyDescriptor([], 'length').enumerable
        // false

        Object.getOwnPropertyDescriptor(class {
            foo() {}
        }.prototype, 'foo').enumerable
        // false

    }

    /** ## 属性的遍历
     * ES6 一共有 5 种方法可以遍历对象的属性。

        （1）for...in

        for...in循环遍历对象自身的和继承的可枚举属性（不含 Symbol 属性）。

        （2）Object.keys(obj)

        Object.keys返回一个数组，包括对象自身的（不含继承的）所有可枚举属性（不含 Symbol 属性）的键名。

        （3）Object.getOwnPropertyNames(obj)

        Object.getOwnPropertyNames返回一个数组，包含对象自身的所有属性（不含 Symbol 属性，但是包括不可枚举属性）的键名。

        （4）Object.getOwnPropertySymbols(obj)

        Object.getOwnPropertySymbols返回一个数组，包含对象自身的所有 Symbol 属性的键名。

        （5）Reflect.ownKeys(obj)

        Reflect.ownKeys返回一个数组，包含对象自身的（不含继承的）所有键名，不管键名是 Symbol 或字符串，也不管是否可枚举。
     */
    {
        //     以上的 5 种方法遍历对象的键名，都遵守同样的属性遍历的次序规则。

        // 首先遍历所有数值键，按照数值升序排列。
        // 其次遍历所有字符串键，按照加入时间升序排列。
        // 最后遍历所有 Symbol 键，按照加入时间升序排列。
        Reflect.ownKeys({
            [Symbol()]: 0,
            b: 0,
            10: 0,
            2: 0,
            a: 0
        })
        // ['2', '10', 'b', 'a', Symbol()]
    }

    /** ## super */
    {
        // 我们知道，this关键字总是指向函数所在的当前对象，ES6 又新增了另一个类似的关键字super，指向当前对象的原型对象。
        const proto = {
            foo: 'hello'
        };

        const obj = {
            foo: 'world',
            find() {
                return super.foo;
            }
        };

        Object.setPrototypeOf(obj, proto);
        obj.find() // "hello"

    }
    //
    {
        const proto = {
            x: 'hello',
            foo() {
                console.log(this.x);
            },
        };

        const obj = {
            x: 'world',
            foo() {
                super.foo();
            }
        }

        Object.setPrototypeOf(obj, proto);

        obj.foo() // "world"
    }

    /** ## 对象的扩展运算符  */
    {
        let {
            x,
            y,
            ...z
        } = {
            x: 1,
            y: 2,
            a: 3,
            b: 4
        };
        x // 1
        y // 2
        z // { a: 3, b: 4 }

    }
    // 注意，解构赋值的拷贝是浅拷贝，即如果一个键的值是复合类型的值（数组、对象、函数）、那么解构赋值拷贝的是这个值的引用，而不是这个值的副本。
    {
        let obj = {
            a: {
                b: 1
            }
        };
        let {
            ...x
        } = obj;
        obj.a.b = 2;
        x.a.b // 2

    }
    // 不能复制继承自原型对象的属性
    {
        let o1 = {
            a: 1
        };
        let o2 = {
            b: 2
        };
        o2.__proto__ = o1;
        let {
            ...o3
        } = o2;
        o3 // { b: 2 }
        o3.a // undefined

    }

    // 解构赋值的一个用处，是扩展某个函数的参数，引入其他操作。
    {
        function baseFunction({
            a,
            b
        }) {
            // ...
        }

        function wrapperFunction({
            x,
            y,
            ...restConfig
        }) {
            // 使用 x 和 y 参数进行操作
            // 其余参数传给原始函数
            return baseFunction(restConfig);
        }

    } {
        // 对象的扩展运算符（...）用于取出参数对象的所有可遍历属性，拷贝到当前对象之中。
        let z = {
            a: 3,
            b: 4
        };
        let n = {
            ...z
        };
        n // { a: 3, b: 4 }

        // 由于数组是特殊的对象，所以对象的扩展运算符也可以用于数组。
        let foo = {
            ...['a', 'b', 'c']
        };
        foo
        // {0: "a", 1: "b", 2: "c"}

    }
</script>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('my-es-code2'); ?>
<script>
    // 简单例子🌰  
    /** ## 克隆 */
    {
        const obj = {};

        // 写法一
        const clone1 = {
            __proto__: Object.getPrototypeOf(obj),
            ...obj
        };

        // 写法二
        const clone2 = Object.assign(
            Object.create(Object.getPrototypeOf(obj)),
            obj
        );

        // 写法三
        const clone3 = Object.create(
            Object.getPrototypeOf(obj),
            Object.getOwnPropertyDescriptors(obj)
        )
        // 写法一的__proto__属性在非浏览器的环境不一定部署，因此推荐使用写法二和写法三。
    }
    // 合并对象
    {
        let a = {
            a_1: 'a'
        };
        let b = {
            b_1: 'b'
        };
        let ab = {
            ...a,
            ...b
        };
        // 等同于
        let ab2 = Object.assign({}, a, b);

    }

    /** 
     * ## 聚合错误对象 
     * const error = new AggregateError([
        new Error('ERROR_11112'),
        new TypeError('First name must be a string'),
        new RangeError('Transaction value must be at least 1'),
        new URIError('User profile link must be https'),
        ], 'Transaction cannot be processed')
    * 
    *
    */
    {
        try {
            throw new AggregateError([
                new Error("some error"),
            ], 'Hello');
        } catch (e) {
            console.log(e instanceof AggregateError); // true
            console.log(e.message); // "Hello"
            console.log(e.name); // "AggregateError"
            console.log(e.errors); // [ Error: "some error" ]
        }

    }
    /** ## Error 对象的 cause 属性 § ⇧ */
    {
        const actual = new Error('an error!', {
            cause: 'Error cause' // casue属性可以放置任意内容，不必一定是字符串。
        });
        actual.cause; // 'Error cause'

    }
</script>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('my-es-code3'); ?>
<script>
    // 简单例子🌰  
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> <?= Inflector::camelize($this->context->action->id) ?> </h4>

    <p>

    </p>

    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s3">
                    <a href="#test1" class="active">基础</a>
                </li>
                <li class="tab col s3">
                    <a href="#test2">其他</a>
                </li>


            </ul>
        </div>
        <!-- tab-pannel  -->
        <div id="test1" class="col s12">

            <pre>
            <code class="language-js">
                <?= \year\widgets\JsBlock::stripScriptTag($this->blocks['my-es-code'])  ?>
                </code>
            </pre>

        </div>
        <!-- tab-pannel  -->
        <div id="test2" class="col s12">
            <pre>
            <code class="language-js">
                <?= \year\widgets\JsBlock::stripScriptTag($this->blocks['my-es-code2'])  ?>
                </code>
            </pre>
        </div>


    </div>

</div>

<?php \year\widgets\JsBlock::begin() ?>
<?= $this->blocks['my-es-code'] ?>
<?= $this->blocks['my-es-code2'] ?>
<?= $this->blocks['my-es-code3'] ?>
<?php \year\widgets\JsBlock::end() ?>

<?php \year\widgets\JsBlock::begin() ?>
<script>
    function _alert(msg) {
        M.toast({
            text: msg,
            classes: 'rounded'
        });
    }

    document.addEventListener('DOMContentLoaded', function() {

        // Tabs 初始化
        var el = document.querySelectorAll('.tabs');
        var options = {};
        var instance = M.Tabs.init(el, options);
    });
</script>
<?php \year\widgets\JsBlock::end() ?>


<?php \year\widgets\CssBlock::begin() ?>
<style>

</style>
<?php \year\widgets\CssBlock::end() ?>