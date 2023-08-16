<?php

use common\widgets\ViewInfo;
use macgyer\yii2materializecss\widgets\Modal;

/**   @var \yii\web\View $this  /
/**    @var string $content  */

// 注册js｜css 所需的asset
$asset = \common\widgets\PrismAsset::register($this);
?>

<?php $this->beginBlock('my-es-code'); ?>
<script>
    function _alert(msg) {
        M.toast({
            text: msg,
            classes: 'rounded'
        });
    }

    /*
    // 老写法
    try {
        Object.defineProperty(target, property, attributes);
        // success
    } catch (e) {
        // failure
    }

    // 新写法
    if (Reflect.defineProperty(target, property, attributes)) {
        // success
    } else {
        // failure
    }
    */
    // 老写法
    let test = 'assign' in Object; // true

    // 新写法
    test = Reflect.has(Object, 'assign'); // true
    _alert(test);


    /**
     *  ## 静态方法 
     * 
    Reflect.apply(target, thisArg, args)
    Reflect.construct(target, args)
    Reflect.get(target, name, receiver)
    Reflect.set(target, name, value, receiver)
    Reflect.defineProperty(target, name, desc)
    Reflect.deleteProperty(target, name)
    Reflect.has(target, name)
    Reflect.ownKeys(target)
    Reflect.isExtensible(target)
    Reflect.preventExtensions(target)
    Reflect.getOwnPropertyDescriptor(target, name)
    Reflect.getPrototypeOf(target)
    Reflect.setPrototypeOf(target, prototype)

    大部分与Object对象的同名方法的作用都是相同的，而且它与Proxy对象的方法是一一对应的
     * */


    var myObject = {
        foo: 1,
        bar: 2,
        get baz() {
            return this.foo + this.bar;
        },
    }

    {
        let r1 = Reflect.get(myObject, 'foo') // 1
        let r2 = Reflect.get(myObject, 'bar') // 2
        let r3 = Reflect.get(myObject, 'baz') // 3
        _alert(r1);
        _alert(r2);
        _alert(r3);
    }

    /** ### 如果name属性部署了读取函数（getter），则读取函数的this绑定receiver。 */
    {
        var myObject = {
            foo: 1,
            bar: 2,
            get baz() {
                return this.foo + this.bar;
            },
        };

        var myReceiverObject = {
            foo: 4,
            bar: 4,
        };

       const result = Reflect.get(myObject, 'baz', myReceiverObject) ;// 8

       _alert(result);
    }
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>

    <div>
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