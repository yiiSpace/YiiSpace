<div class="test-default-index">
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

<?php \year\widgets\IframeResizerAsset::register($this) ?>

<?php \year\widgets\JsBlock::begin() ?>
<script>
    function resize()
    {
        window.parent.autoResize();
    }

    $(window).on('resize', resize);
</script>
<?php \year\widgets\JsBlock::end() ?>
