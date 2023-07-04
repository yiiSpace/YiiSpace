<?php
use common\widgets\ViewInfo;
use macgyer\yii2materializecss\widgets\Modal;

/**   @var \yii\web\View $this  /
/**    @var string $content  */

// 注册js｜css 所需的asset

$asset =\common\widgets\PrismAsset::register($this);
// 手动加载插件的代码示例
// $cdnUrl = $asset->getCDNUrl();
// $pluginJs = $cdnUrl.'/plugins/autoloader/prism-autoloader.min.js';

// array_push($asset->js,$pluginJs) ; 



  Modal::begin([
       'closeButton' => [
            'label' => 'Close modal',
            'tag' => 'span'
        ],
       'toggleButton' => [
            'label' => 'Open modal'
        ],
        'modalType' => Modal::TYPE_LEAN,
   ]);
  
   echo 'Say hello...';
  
   Modal::end();
   
   ?>



 <?php $this->beginBlock('my-es-code'); ?>
 <script>
    
    

</script>
 <?php $this->endBlock(); ?>



<div class="js-es6-index">
<?= ViewInfo::widget(); ?>

    <div>
    <pre><code class="language-js">
    <?=  \year\widgets\JsBlock::stripScriptTag($this->blocks['my-es-code'])  ?>
    </code></pre>
    </div>

    <button type="button" class="btn" onclick="M.toast({text: 'I am a toast', completeCallback: function(){alert('Your toast was dismissed')}})">Toast!</button>
</div>


<?php \year\widgets\JsBlock::begin() ?>

<?= $this->blocks['my-es-code'] ?>

<?php \year\widgets\JsBlock::end() ?>


<?php \year\widgets\CssBlock::begin() ?>
<style>
   
</style>
<?php \year\widgets\CssBlock::end() ?>