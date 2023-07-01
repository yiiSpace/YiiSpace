<?php
use common\widgets\ViewInfo;

/** @var \yii\web\View $this */
/** @var string $content */

// 注册js｜css 所需的asset

$asset =\common\widgets\PrismAsset::register($this);
// 手动加载插件的代码示例
$cdnUrl = $asset->getCDNUrl();
$pluginJs = $cdnUrl.'/plugins/autoloader/prism-autoloader.min.js';

array_push($asset->js,$pluginJs) ; 

?>

<?php  ?>


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