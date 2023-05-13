<?php
/** @var \yii\web\View $this */
/** @var string $content */

// 试下动态生成表单


?>

<div class="php-default-index">
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






</div>
<?php \year\widgets\JsBlock::begin() ?>
<script>



</script>
<?php \year\widgets\JsBlock::end() ?>