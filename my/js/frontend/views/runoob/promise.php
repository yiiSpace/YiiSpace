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
        let p = new Promise((resolve, reject) => {
            // 一些异步操作之后
            let result = (()=>{
                Math.floor((Math.random()*10)+1) > 5; 
            })();

            if (result == true) {
                resolve('some-result');
            } else {
                reject('some-error');
            }
        });

        p.then((value) => {
            console.log(value);
        })
        .catch((reason)=>{
            console.log('[promise-error]:', reason) ;
        });
    }
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <?= 
    ViewInfo::widget(); 
    ?>
    <h4> Promise </h4>
    <p>

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