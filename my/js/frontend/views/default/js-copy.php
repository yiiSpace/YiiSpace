<?php

use common\widgets\ViewInfo;

/** @var \yii\web\View $this */
/** @var string $content */

// 注册js｜css 所需的asset

$asset = \common\widgets\PrismAsset::register($this);

?>

<?php $this->beginBlock('my-es-code'); ?>
<script>
    /**
     * 参考：JS对象拷贝之深拷贝与浅拷贝 https://zhuanlan.zhihu.com/p/446160588
     * 
     * 深拷贝和浅拷贝是只针对像object、array这样复杂的对象。
     * 
     * js中的对象分为基本类型和复合（引用）类型，前者存放在栈内存，后者存放在堆内存。
     * 堆内存用于存放由new创建的对象，栈内存存放一些基本类型的变量和对象的引用变量。
     * 
     * - 浅拷贝 对对象地址的复制，不会进行递归复制，并没有开辟新的栈，也就是复制的结果是两个对象指向同一个地址。
     * - 深拷贝指的是：将原对象的各个属性逐个复制出去，而且将原对象各个属性所包含的对象也依次采用深复制的方法递归复制到新对象上。并开辟了一块新的内存地址来存放复制的对象。

     * 参考：https%3A//github.com/lodash/lodash/blob/master/.internal/baseClone.js
     */

    // 浅拷贝 参考阮一峰文档： https://es6.ruanyifeng.com/#docs/object-methods#Object-assign
    const clone = Object.create(
        Object.getPrototypeOf(obj),
        Object.getOwnPropertyDescriptors(obj)
    );

    // 待拷贝的对象
    let originObj = {
        re: /hello/,
        ff: function() {},
        sym: Symbol(123),
        date: new Date(),
        mp: new Map(),
        st: new Set(),
        a: "aaa",
        b: 123,
        c: true,
        d: undefined,
        e: null,
        f: {
            f1: "fff",
            f2: {
                a: "aaa",
                b: 123,
                c: true,
                d: undefined,
                e: null
            },
            f3: [{
                a: "aaa",
                b: 123,
                c: true,
                d: undefined,
                e: null
            }, "f666", 666],
        },
        g: [1, 2, 3],
        h: [{
            a: "aaa",
            b: 123,
            c: true,
            d: undefined,
            e: null
        }, "f666", 666],
    };
    var obj222 = {
        a: originObj,
    };
    originObj.obj222 = obj222;
    // 简单实现，缺点：没有考虑 Date/RegExp/Set/Map/循环引用，如果有循环引用会报错栈溢出
    function cloneDeep(obj) {
        let objClone = obj.constructor === Array ? [] : Object.create({});
        for (const key in obj) {
            if (obj.hasOwnProperty(key)) {
                // Object.prototype.toString.call(/123/)
                if (obj[key] && typeof obj[key] === "object") {
                    objClone[key] = cloneDeep(obj[key]);
                } else {
                    objClone[key] = obj[key];
                }
            }
        }
        return objClone;
    }
    // 详细实现
    /**
     * 深拷贝关注点:
     * 1. JavaScript内置对象的复制: Set、Map、Date、RegExp等
     * 2. 循环引用问题
     * @param {*} object
     * @returns
     */
    function deepClone(source, memory) {
        const isPrimitive = (value) => {
            return /Number|Boolean|String|Null|Undefined|Symbol|Function/.test(
                Object.prototype.toString.call(value)
            );
        };
        let result = null;
        let type = Object.prototype.toString.call(source);
        memory || (memory = new WeakMap());
        // 原始数据类型及函数
        if (isPrimitive(source)) {
            // console.log("current copy is primitive", source);
            result = source;
        }
        // 数组
        else if (Array.isArray(source)) {
            result = source.map((value) => deepClone(value, memory));
        }
        // 内置对象Date、Regex
        else if (type === "[object Date]") {
            result = new Date(source);
        } else if (type === "[object RegExp]") {
            result = new RegExp(source);
        }
        // 内置对象Set、Map
        else if (type === "[object Set]") {
            result = new Set();
            for (const value of source) {
                result.add(deepClone(value, memory));
            }
        } else if (type === "[object Map]") {
            result = new Map();
            for (const [key, value] of source.entries()) {
                result.set(key, deepClone(value, memory));
            }
        }
        // 引用类型
        else {
            if (memory.has(source)) {
                result = memory.get(source);
            } else {
                result = Object.create(null);
                memory.set(source, result);
                Object.keys(source).forEach((key) => {
                    const value = source[key];
                    result[key] = deepClone(value, memory);
                });
            }
        }
        return result;
    }

    console.log(cloneDeep(originObj));
    console.log(deepClone(originObj));

    // 参考：https://github.com/shfshanyue/Daily-Question/issues/203#issuecomment-888238489
</script>
<?php $this->endBlock(); ?>



<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>

    <div>

        <a href="https://cloud.tencent.com/developer/article/2079992">参考 蓓蕾心晴 js对象拷贝方法</a>

        <pre><code class="language-js">
    <?= \year\widgets\JsBlock::stripScriptTag($this->blocks['my-es-code'])  ?>
    </code></pre>
    </div>
</div>


<?php \year\widgets\JsBlock::begin() ?>

<?= $this->blocks['my-es-code'] ?>

<?php \year\widgets\JsBlock::end() ?>


<?php \year\widgets\CssBlock::begin() ?>
<style>

</style>
<?php \year\widgets\CssBlock::end() ?>