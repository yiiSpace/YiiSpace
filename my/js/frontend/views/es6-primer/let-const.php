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
    for (let i = 0; i < 10; i++) {
        // ...

    }
    // console.log(i); // i只在循环体内可用

    // var命令声明的，在全局范围内都有效
    var a = [];
    for (var i = 0; i < 10; i++) {
        a[i] = function() {
            console.log(i); // 访问的是同一个i
        };
    }
    a[6](); // 10

    // (() => {
    var a = [];
    for (let i = 0; i < 10; i++) {
        a[i] = function() {
            console.log(i);
        };
    }
    a[6](); // 6

    // })()

    for (let i = 0; i < 3; i++) {
        // console.log(i);
        let i = 'abc'; // i跟父for 不在同一个作用域 同一个作用域不可使用 let 重复声明同一个变量
        console.log(i);
    }

    /** ## 变量提升 */
    // var 的情况
    // 即变量可以在声明之前使用，值为undefined
    console.log(foo); // 输出undefined
    var foo = 2;

    // let 的情况
    // console.log(bar); // 报错ReferenceError
    let bar = 2;


    /** 
     * ## 暂时性死区 
     * 
     * 只要块级作用域内存在let命令，它所声明的变量就“绑定”（binding）这个区域，不再受外部的影响。
     * 
     * 在代码块内，使用let命令声明变量之前，该变量都是不可用的。这在语法上，称为“暂时性死区”（temporal dead zone，简称 TDZ）
     * 
     * - “暂时性死区”也意味着typeof不再是一个百分之百安全的操作。
     * 
     */
    var tmp = 123;

    if (true) {
        // tmp = 'abc'; // ReferenceError 此处tmp就跟外面var声明的那个无关了
        let tmp;
    }

    if (true) {
        // TDZ开始
        tmp = 'abc'; // ReferenceError
        console.log(tmp); // ReferenceError

        let tmp; // TDZ结束
        console.log(tmp); // undefined

        tmp = 123;
        console.log(tmp); // 123
    }

    // 
    typeof undeclared_variable // "undefined"


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
                    <a href="#test1" class="active">let 基础</a>
                </li>
                <li class="tab col s3">
                    <a href="#test2">其他</a>
                </li>


            </ul>
        </div>

        <div id="test1" class="col s12">

            <pre>
            <code class="language-js">
                <?= \year\widgets\JsBlock::stripScriptTag($this->blocks['my-es-code'])  ?>
                </code>
            </pre>

        </div>

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