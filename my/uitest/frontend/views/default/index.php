<div class="uitest-default-index">
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

<div>
    <?php
    // \yii\data\ActiveDataProvider::
    $pagination = new \yii\data\Pagination();
    $pagination->totalCount = 100;
    $pagination->setPage(3);
    ?>
    <?= \year\uikit\core\Pagination::widget(
        [
            'pagination' => $pagination,
        ]
    ) ?>
</div>

<div>
    <!-- This is the anchor toggling the modal -->
    <a href="#my-id" data-uk-modal>对话框哦</a>

    <!-- This is the modal -->
    <div id="my-id" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-lightbox">
            <a href="" class="uk-modal-close uk-close uk-close-alt"></a>
            <img src="" alt="">
        </div>
    </div>

</div>


<div class="uk-grid">
    <div class="uk-width-1-2">.
        ..
    </div>
    <div class="uk-width-1-2">..
        .
    </div>
</div>

<div class="uk-grid">
    <div class="uk-width-1-2">...</div>
    <div class="uk-width-1-2">
        <div class="uk-grid">
            <div class="uk-width-1-2">...</div>
            <div class="uk-width-1-2">...</div>
        </div>
    </div>
</div>