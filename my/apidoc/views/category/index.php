<?php
/* @var $this yii\web\View */
?>

<?php \year\widgets\CssBlock::begin() ?>
<style>
    .api-list-item {
        margin-top: 10px;
        padding-bottom: 25px;
        border-bottom: dotted #22ccdd 1px;
    }

    .api-list-intro {
        margin-top: 15px;
    }
</style>
<?php \year\widgets\CssBlock::end() ?>

<div>

    <h1>
        API列表
    </h1>

    <ul class="layout">
        <?php foreach ($apiCategories as $apiCategory): ?>
            <?php //  print_r($apiCategory) ?>
            <li class="api-list-item ">
            <span>
                <a class="link" href="<?= \yii\helpers\Url::to(['view', 'id' => urlencode($apiCategory['name'])]) ?>">
                    <?= $apiCategory['shortDescription'] ?>
                </a>
            </span>

                <p class="api-list-intro">
                    <?= $apiCategory['description'] ?>

                    <?php if (YII_DEBUG): ?>
                <div class="alert">
                    api类寄居在：<?= $apiCategory['path'] ?>
                </div>
                <?php endif ?>

                </p>
            </li>
        <?php endforeach ?>
    </ul>

</div>

<h1>category/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
