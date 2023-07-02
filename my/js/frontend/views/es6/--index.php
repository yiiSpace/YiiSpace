<?php
use common\widgets\ViewInfo;

/** @var \yii\web\View $this */
/** @var string $content */

// 注册js｜css 所需的asset

$asset =\common\widgets\PrismAsset::register($this);
?>

<?php \year\widgets\JsBlock::begin() ?>
<script type="text/javascript">


</script>
<?php \year\widgets\JsBlock::end() ?>

<div class="js-es6-index">
<?= ViewInfo::widget(); ?>

    <div>
    <pre><code class="language-css">p { color: red }</code></pre>
    </div>
</div>


<?php \year\widgets\CssBlock::begin() ?>
<style>
   
   
</style>
<?php \year\widgets\CssBlock::end() ?>