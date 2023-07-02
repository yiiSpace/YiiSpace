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