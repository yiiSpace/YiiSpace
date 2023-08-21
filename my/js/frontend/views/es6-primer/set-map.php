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
    console.log(Set);
    console.log(Set.prototype);
    {
        const s = new Set();

        [2, 3, 5, 4, 5, 2, 2].forEach(x => s.add(x));

        for (let i of s) {
            console.log(i);
        }
        // 2 3 5 4

    }
    // array || iterable 
    {
        // 例一
        const set = new Set([1, 2, 3, 4, 4]);
        [...set]
        // [1, 2, 3, 4]
    } {
        // 例二
        const items = new Set([1, 2, 3, 4, 5, 5, 5, 5]);
        items.size // 5
    } {
        // 例三
        const set = new Set(document.querySelectorAll('div'));
        _alert(set.size); // 41
    }
    // 类似
    {
        // 类似于
        const set = new Set();
        document
            .querySelectorAll('div')
            .forEach(div => set.add(div));
        set.size // 56
    }
    /** ## 去重 */
    {
        const array = [1, 2, 2, 3, 3];
        _alert( // 去除数组的重复成员
            [...new Set(array)]
        );
        _alert(
            [...new Set('ababbc')].join('')
        );
    } {
        let set = new Set();

        set.add({});
        set.size // 1

        set.add({});
        set.size // 2

    }

    /** ## 数组 */
    {
        const items = new Set([1, 2, 3, 4, 5]);
        const array = Array.from(items);

        // 去重
        function dedupe(array) {
            return Array.from(new Set(array));
        }

        dedupe([1, 1, 2, 3]) // [1, 2, 3]

    }

    /** ## 遍历 */
    /**
     * 
    Set.prototype.keys()：返回键名的遍历器
    Set.prototype.values()：返回键值的遍历器
    Set.prototype.entries()：返回键值对的遍历器
    Set.prototype.forEach()：使用回调函数遍历每个成员
     */
    {
        // 需要特别指出的是，Set的遍历顺序就是插入顺序。
        // 这个特性有时非常有用，比如使用 Set 保存一个回调函数列表，调用时就能保证按照添加顺序调用。


        let set = new Set(['red', 'green', 'blue']);

        for (let item of set.keys()) {
            console.log(item);
        }
        // red
        // green
        // blue

        for (let item of set.values()) {
            console.log(item);
        }
        // red
        // green
        // blue

        for (let item of set.entries()) {
            console.log(item);
        }
        // ["red", "red"]
        // ["green", "green"]
        // ["blue", "blue"]


    }
    // Set 结构的实例默认可遍历，它的默认遍历器生成函数就是它的values方法。
    {
        console.log(Set.prototype[Symbol.iterator] === Set.prototype.values);

        let set = new Set(['red', 'green', 'blue']);

        for (let x of set) {
            console.log(x);
        }
        // red
        // green
        // blue

    }
    // foreach
    {
        let set = new Set([1, 4, 9]);
        set.forEach((value, key, _s) => console.log(key + ' : ' + value))
    }

    /** ## 遍历的使用 */
    {
        // 扩展运算符（...）内部使用for...of循环，所以也可以用于 Set 结构。
        {
            let set = new Set(['red', 'green', 'blue']);
            let arr = [...set];
            // ['red', 'green', 'blue']

        }
        // 去重
        {
            let arr = [3, 5, 2, 2, 5, 5];
            let unique = [...new Set(arr)];
            // [3, 5, 2]

        }
        // 数组的map和filter方法也可以间接用于 Set 了。
        {
            let set = new Set([1, 2, 3]);
            set = new Set([...set].map(x => x * 2));
            // 返回Set结构：{2, 4, 6}

            set = new Set([1, 2, 3, 4, 5]);
            set = new Set([...set].filter(x => (x % 2) == 0));
            // 返回Set结构：{2, 4}

        }
        // 因此使用 Set 可以很容易地实现并集（Union）、交集（Intersect）和差集（Difference）。
        {
            let a = new Set([1, 2, 3]);
            let b = new Set([4, 3, 2]);

            // 并集
            let union = new Set([...a, ...b]);
            // Set {1, 2, 3, 4}

            // 交集
            let intersect = new Set([...a].filter(x => b.has(x)));
            // set {2, 3}

            // （a 相对于 b 的）差集
            let difference = new Set([...a].filter(x => !b.has(x)));
        }
        /** 
         * 如果想在遍历操作中，同步改变原来的 Set 结构，目前没有直接的方法，但有两种变通方法。
         * 一种是利用原 Set 结构映射出一个新的结构，然后赋值给原来的 Set 结构；
         * 另一种是利用Array.from方法。
         */
        {
            // 方法一
            let set = new Set([1, 2, 3]);
            set = new Set([...set].map(val => val * 2));
            // set的值是2, 4, 6

            // 方法二
            set = new Set([1, 2, 3]);
            set = new Set(Array.from(set, val => val * 2));
            // set的值是2, 4, 6

        }
    }
</script>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('my-es-code2'); ?>
<script>
    // 简单例子🌰  
    console.log(WeakSet);
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
<script>
    function _alert(msg) {
        const args = Array.prototype.slice.call(arguments, 0);
        //    console.log(args); // 可以👀到Array的方法
        //    const args = Array.from(arguments) ; // ES6之后支持 [...arguments] 也可以！
        msg = args.join(' ');
        M.toast({
            text: msg,
            classes: 'rounded'
        });
    }
</script>
<?= $this->blocks['my-es-code'] ?>
<?= $this->blocks['my-es-code2'] ?>
<?= $this->blocks['my-es-code3'] ?>
<?php \year\widgets\JsBlock::end() ?>

<?php \year\widgets\JsBlock::begin() ?>
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