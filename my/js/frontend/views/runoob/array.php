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
    {
        var cars = ["Saab", "Volvo", "BMW"];

        console.log(cars);
    }
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <?= 
    ViewInfo::widget(); 
    ?>
    <h4> <?= Inflector::camelize($this->context->action->id) ?> </h4>
    <p>
    <i class="material-icons">add</i>
    <i class="material-icons">access_time</i>

    <span class="material-icons">pie_chart</span>          <!-- Filled -->
<span class="material-icons-outlined">pie_chart</span> <!-- Outlined -->
<span class="material-icons-round">pie_chart</span>    <!-- Round -->
<span class="material-icons-sharp">pie_chart</span>    <!-- Sharp -->
<span class="material-icons-two-tone">pie_chart</span> <!-- Two Tone -->

    </p>
    <div>
        <pre><code class="language-js">
    <?= \year\widgets\JsBlock::stripScriptTag($this->blocks['my-es-code'])  ?>
    </code></pre>
    </div>


<!-- 这里有yii-widget组件写法 有时候用‘裸写’速度更快 有空了再改 -->
<div class="fixed-action-btn">
  <a class="btn-floating btn-large" href="https://www.runoob.com/jsref/jsref-obj-array.html" target="_blank">
    参考
  </a>
  <ul>
    <li><a class="btn-floating"><i class="material-icons">insert_chart</i></a></li>
    <li><a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a></li>
    <li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
    <li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>
  </ul>
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
    document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.fixed-action-btn');
    var instances = M.FloatingActionButton.init(elems, {
      // specify options here
    });
  });
</script>
<?php \year\widgets\JsBlock::end() ?>


<?php \year\widgets\CssBlock::begin() ?>
<style>

</style>
<?php \year\widgets\CssBlock::end() ?>