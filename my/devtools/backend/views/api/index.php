<?php
/* @var $this yii\web\View */
?>
<h1>api/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>

<?= $this->render('_form',[
    'model'=>$model,
]); ?>


<?php if( !empty($model->tableName) ): ?>
    <?= $this->render('_create',[
        'model'=>$model,
    ]) ?>

    <div>
        <p>
            关于跟关联模型的搜索 参考
            <ul>
            <li>
                <a href="http://www.yiiframework.com/wiki/780/drills-search-by-a-has_many-relation-in-yii-2-0/">
                  drills-search-by-a-has_many-relation-in-yii-2-0/
                </a>
            </li>
            <li>
                <a href="http://www.yiiframework.com/wiki/621/filter-sort-by-calculated-related-fields-in-gridview-yii-2-0/">
                    filter-sort-by-calculated-related-fields-in-gridview-yii-2-0/
                </a>
            </li>
            <li>
                <a href="http://www.yiiframework.com/wiki/679/filter-sort-by-summary-data-in-gridview-yii-2-0/">
                    filter-sort-by-summary-data-in-gridview-yii-2-0/
                </a>
            </li>
            <li>
                <a href="http://www.yiiframework.com/wiki/653/displaying-sorting-and-filtering-model-relations-on-a-gridview">
                    displaying-sorting-and-filtering-model-relations-on-a-gridview
                </a>
            </li>
        </ul>
        </p>
    </div>
    <?= $this->render('_index',[
        'model'=>$model,
    ]) ?>

    <?= $this->render('_batch-insert',[
        'model'=>$model,
    ]) ?>

<?php endif ?>


<?php \year\widgets\HighLightJsAsset::register($this); ?>

<?php \year\widgets\JsBeautifyAsset::register($this) ?>

<?php \year\widgets\JsBlock::begin() ?>
<script>
    $(function () {

        $('code').each(function () {
            // console.log(this);
            $(this).text(js_beautify($(this).text()));

        });
        $('code').wrap('<pre></pre>');

        /*
         // 代码高亮
         hljs.configure({useBR: true});
         $('code').each(function (i, block) {
         hljs.highlightBlock(block);
         });
         */
    });
</script>
<?php \year\widgets\JsBlock::end() ?>
