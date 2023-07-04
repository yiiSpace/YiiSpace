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
      console.log(Number('0b11')) ;
      console.log(Number('0o11')) ;
      console.log(Number('0x11')) ;
        
    }

    // 检测类函数
    {
        console.log(Number.isFinite(100000000));
        console.log(Number.isFinite('sjdfj100'));
        console.log(Number.isNaN('sjdfj100'));

        console.log(Number.isInteger(399));
    }

    // 转换类
    {
        console.log(Number.parseInt('500'))
        console.log(Number.parseFloat('500.02'))
        console.log(Number.parseFloat('abc500.02xyz'))
    }

    // 常量
    {
        console.log(Number.EPSILON);
        console.log(Number.EPSILON.toFixed(30));
        console.log((0.1+0.2-0.3).toFixed(20));
        console.log((0.1+0.2-0.3) < Number.EPSILON.toFixed(30)); // php 使用bc库来支持高精度运算
    }

    // 指数运算
    {
        console.log(2 ** 3);
        let num = 2 ;
        num **=5 ;
        console.log(num) ;
    }

    // ===   Math 方法
    {
        console.log(Math.trunc(5.55)); // 去掉小数部分
        console.log(Math.sign(5.55)); // 判断正负 0 还是NaN
        console.log(Math.cbrt(2)); // 求立方根
        console.log(Math.clz32(1)); // 求三十二位2进制
        console.log(Math.imul(2,-4)); // 两数整数相乘带符号
        console.log(Math.fround(3.1415926)); // 求一个数的单精度浮点形式
        console.log(Math.hypot(3,4)); // 求参数的平方和的平方根
        console.log(Math.expm1(-1)); //  
        
        console.log(Math.log1p(1)); // ln(1+x) , Math.log(1+x)
        console.log(Math.log10(1)); // 10为底的对数
        console.log(Math.log2(3)); //  2为底 对数

        // console.log(5.55.trunc());

    }
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> 数值｜Math数学 扩展及改进 </h4>
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