<?php

/** @var \yii\web\View $this */
/** @var string $content */

// 注册js｜css 所需的asset

\common\widgets\WangEditorAsset::register($this);

?>

<?php \year\widgets\JsBlock::begin() ?>
<script type="text/javascript">


const { createEditor, createToolbar } = window.wangEditor

const editorConfig = {
    placeholder: 'Type here...',
    onChange(editor) {
      const html = editor.getHtml()
      console.log('editor content', html)
      // 也可以同步到 <textarea>
    }
}

const editor = createEditor({
    selector: '#editor-container',
    html: '<p><br></p>',
    config: editorConfig,
    mode: 'default', // or 'simple'
})

const toolbarConfig = {}

const toolbar = createToolbar({
    editor,
    selector: '#toolbar-container',
    config: toolbarConfig,
    mode: 'default', // or 'simple'
})


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
        <div id="editor—wrapper">
            <div id="toolbar-container"><!-- 工具栏 --></div>
            <div id="editor-container"><!-- 编辑器 --></div>
        </div>

    </div>
</div>


<?php \year\widgets\CssBlock::begin() ?>
<style>
    #editor—wrapper {
        border: 1px solid #ccc;
        z-index: 100;
        /* 按需定义 */
    }

    #toolbar-container {
        border-bottom: 1px solid #ccc;
    }

    #editor-container {
        height: 500px;
    }
</style>

<?php \year\widgets\CssBlock::end() ?>