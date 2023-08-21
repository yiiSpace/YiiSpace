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
    console.log(Symbol);

    {
        let s1 = Symbol('foo');
        let s2 = Symbol('bar');

        s1 // Symbol(foo)
        s2 // Symbol(bar)

        s1.toString() // "Symbol(foo)"
        s2.toString() // "Symbol(bar)"

    }
    // 参数是对象形式
    {
        const obj = {
            toString() {
                return 'abc';
            }
        };
        const sym = Symbol(obj);
        sym // Symbol(abc)

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