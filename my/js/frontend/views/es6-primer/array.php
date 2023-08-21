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
    console.log(Array);


    {
        // ## 扩展运算符...
        console.log(...[1, 2, 3]);

        // 替代函数的 apply() 方法
        {
            // ES5 的写法
            function f(x, y, z) {
                // ...
            }
            var args = [0, 1, 2];
            f.apply(null, args);

        }

        {
            // ES6 的写法
            function f(x, y, z) {
                // ...
            }
            let args = [0, 1, 2];
            f(...args);
        }
        // 实际例子
        {
            // ES5 的写法
            Math.max.apply(null, [14, 3, 77])

            // ES6 的写法
            Math.max(...[14, 3, 77])

            // 等同于
            Math.max(14, 3, 77);

        } {
            // ES5 的写法
            var arr1 = [0, 1, 2];
            var arr2 = [3, 4, 5];
            Array.prototype.push.apply(arr1, arr2);

            // ES6 的写法
            let arr1 = [0, 1, 2];
            let arr2 = [3, 4, 5];
            arr1.push(...arr2);

        } {
            // ES5
            new(Date.bind.apply(Date, [null, 2015, 1, 1]))

            // ES6
            new Date(...[2015, 1, 1]);
        }

        // ### 数组复制
        {
            {

                const a1 = [1, 2];
                const a2 = a1.concat(); // 变通方法
            }

            // 使用扩展运算符
            {
                const a1 = [1, 2];
                // 写法一
                const a2 = [...a1];
                // 写法二
                const [...a2_2] = a1;

            }
        }

        // ## 解构
        {
            // const [first, ...rest] = [1, 2, 3, 4, 5];
            first // 1
            rest // [2, 3, 4, 5]

            // const [first, ...rest] = [];
            first // undefined
            rest // []

            const [first, ...rest] = ["foo"];
            first // "foo"
            rest // []

        }

        // iterator配合使用
        /**
         * 扩展运算符内部调用的是数据结构的 Iterator 接口，因此只要具有 Iterator 接口的对象，都可以使用扩展运算符，比如 Map 结构。
         */
        {
            let map = new Map([
                [1, 'one'],
                [2, 'two'],
                [3, 'three'],
            ]);

            let arr = [...map.keys()]; // [1, 2, 3]

        } {
            const go = function*() {
                yield 1;
                yield 2;
                yield 3;
            };

            [...go()] // [1, 2, 3]

        }

    }

    {
        // ## concate
        let a1 = [1, 2, 3];
        let a2 = [4, 5, "6"];
        console.log(a1.concat(a2));
    }

    /** ## Array.from  */
    {
        let arrayLike = {
            '0': 'a',
            '1': 'b',
            '2': 'c',
            length: 3
        };

        // ES5 的写法
        var arr1 = [].slice.call(arrayLike); // ['a', 'b', 'c']

        // ES6 的写法
        let arr2 = Array.from(arrayLike); // ['a', 'b', 'c']

        // 实际应用
        {
            // NodeList 对象
            let ps = document.querySelectorAll('p');
            Array.from(ps).filter(p => {
                return p.textContent.length > 100;
            });

            // arguments 对象
            function foo() {
                var args = Array.from(arguments);
                // ...
            }

        }
        //  实现iterator接口
        {
            Array.from('hello')
            // ['h', 'e', 'l', 'l', 'o']

            let namesSet = new Set(['a', 'b'])
            Array.from(namesSet) // ['a', 'b']

        }

        // ... to be continue

    }

    /** ## Array.of 方法用于将一组值，转换为数组。 */
    {
        {
            Array.of(3, 11, 8) // [3,11,8]
            Array.of(3) // [3]
            Array.of(3).length // 1
        }
    }
</script>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('my-es-code2'); ?>
<script>
    // 简单例子🌰  
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