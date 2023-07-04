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
    // 简单例子🌰  
    {
        // let s = new Symbol();
        let s = Symbol();
        console.log(s);
        console.log(typeof s);

        let s2 = Symbol();
        console.log(s2 === s);
    }
    // 转换
    {
        let s = Symbol('s');

        console.log(s.toString() + '');
        console.log(String(s) + '');
        console.log(!s);
    }

    // 用例场景
    {
        let obj = {
            name: 'qing',
            name: 'qiang',
        };
        console.log(obj.name);

        let x = 'name',
            y = 'name';
        obj = {
            ['key'+x] : 'x-value',
            ['key'+y] : 'y-value',
        }
        console.log(obj['key'+x]);
        console.log(Object.keys(obj));
    }
    {
        let x = Symbol('x'),
            y = Symbol('x');
        obj = {
            [ x] : 'x-value',
            [ y] : 'y-value',
        }
        console.log(obj) ;
        // console.log(obj['key'+x]);
        console.log(Object.keys(obj));
        console.log( obj[x]);
        console.log( obj[y]);

        // 这看起来就像一个发号器！避免重名！
        let method1 = Symbol();
        obj[method1] = function(){}
        console.log(obj) ;
    }
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> Symbol 类型和属性 </h4>
    <p>
        Symbol 是Es6 新增的类型 ；表示独一无二的值，类似 ID
        以前有个符号表的概念
    </p>
    <div>
        <pre><code class="language-js">
    <?= \year\widgets\JsBlock::stripScriptTag($this->blocks['my-es-code'])  ?>
    </code></pre>
    </div>

</div>


<?php \year\widgets\JsBlock::begin() ?>
<?= $this->blocks['my-es-code'] ?>
<?php \year\widgets\JsBlock::end() ?>

<?php \year\widgets\JsBlock::begin() ?>
<script>
    function _alert(msg) {
        M.toast({
            text: msg,
            classes: 'rounded'
        });
    }
</script>
<?php \year\widgets\JsBlock::end() ?>


<?php \year\widgets\CssBlock::begin() ?>
<style>

</style>
<?php \year\widgets\CssBlock::end() ?>