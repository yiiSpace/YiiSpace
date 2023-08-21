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

    /** ## 指数运算符 */
    {
        _alert(2 ** 2, 2 ** 3, 2 ** 3 ** 2); // // 相当于 2 ** (3 ** 2)

        // 赋值运算符
        let a = 1.5;
        a **= 2;
        // 等同于 a = a * a;

        let b = 4;
        b **= 3;
        // 等同于 b = b * b * b;

    }
    /** ## 链判断运算符 § ⇧ */
    {
        const message = { /** from some api-call */ };
        // 错误的写法
        // const firstName = message.body.user.firstName || 'default';

        // 正确的写法
        const firstName = (message &&
            message.body &&
            message.body.user &&
            message.body.user.firstName) || 'default';

        // firstName属性在对象的第四层，所以需要判断四次，每一层是否有值。
    } 
    
    // optional chaining operator）?.   ES2020引入
    {
    const message = { /** from some api-call */ };

        const firstName = message?.body?.user?.firstName || 'default';

        // const myForm = document.getElementById('myform');
        // const fooValue = myForm.querySelector('input[name=foo]')?.value
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