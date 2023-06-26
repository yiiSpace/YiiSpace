<?php

/** @var \yii\web\View $this */
/** @var string $content */

// 注册js｜css 所需的asset

$asset =\common\widgets\PrismAsset::register($this);
// 手动加载插件的代码示例
$cdnUrl = $asset->getCDNUrl();
$pluginJs = $cdnUrl.'/plugins/autoloader/prism-autoloader.min.js';

array_push($asset->js,$pluginJs) ; 
?>

<?php \year\widgets\JsBlock::begin() ?>
<script type="text/javascript">


</script>
<?php \year\widgets\JsBlock::end() ?>

<div class="js-defualt-wang-editor">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>


    <div>
    <pre><code class="language-css">p { color: red }</code></pre>
    </div>
</div>


<?php \year\widgets\CssBlock::begin() ?>
<style>
   
   
</style>
<?php \year\widgets\CssBlock::end() ?>