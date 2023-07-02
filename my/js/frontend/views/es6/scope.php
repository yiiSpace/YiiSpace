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
    // 作用域 就分 函数作用域 跟全局作用域 

    function _alert(msg) {
        M.toast({
            text: msg,
            classes: 'rounded'
        });
    }
    // Node环境下 也有个顶级对象 global
    console.log(window); // TODO 可以查看window对象的所有属性么？看👀控制台哦

    console.log(window.name); // name 就是window的属性 不过是空值
    console.log(window.some_var) ; // undifined
   
    // 不要window前缀
    // console.log(name, some_var ) ;
    console.log(name === window.name) ;
    var name = 'qing' ; // 同名覆盖现象 
    // name = 'qing' ;
    console.log(name, window.name) ;

    // 自动变为window属性
    var some_v = 'hi';
    console.log(window.some_v) ;

    // ⚠️ 使用var 会引起全局变量污染问题😯
    // ES6之前使用 闭包即时执行函数来防治变量污染

    (function(){
        var v1 = 'some value' ;
    })();
    console.log(v1) ;

    // 现在可以使用let 了

    // 块内定义 块外仍可访问 if(some_cond){ function some_fn(){} } else{ funciton some_fn(){}}
    {
        function some_fn(){
            console.log('some_fn is called');
        }
    }
    some_fn();

    // 只允许块内访问
    {
        // let 声明具有块级作用域 
        let some_fn = function(){
            console.log('some_fn is called'); 
        }
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