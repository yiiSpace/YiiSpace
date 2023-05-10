<?php
// _list_item.php
use yii\db\TableSchema;
use yii\helpers\Html;
use yii\helpers\Url;
/** @var yii\web\View $this */
/** @var array $model */
/** @var TableSchema $tableSchema */
/** @var \yii\db\ColumnSchema $columnSchema */


?>

<article class="item" data-key="<?= $model['id']; ?>">
    <h2 class="title">
<!--        --><?php //= Html::a(Html::encode($model->title), Url::toRoute(['post/show', 'id' => $model->id]), ['title' => $model->title]) ?>
        <?= $model['id'] ?>
    </h2>

    <div class="item-excerpt">
<!--        --><?php //= Html::encode($model->excerpt); ?>
    </div>
</article>

<div class="card">
    <div class="card-body">
        This is some text within a card body.
    </div>
</div>

<div class="card" style="width: 18rem;">
    <img src="..." class="card-img-top" alt="...">
    <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
        <?php
        $tableSchema = $model['tableSchema'] ;
        /**
         * @var array $columnNames
         */
        $columnNames = $tableSchema->getColumnNames() ;

        foreach ($columnNames as $columnName):
        $columnSchema = $tableSchema->getColumn($columnName) ;
        ?>

            <span class="badge badge-primary"><?= $columnName ?></span>
            <span class="badge badge-info"><?= $columnSchema->comment ?></span>
            <span class="badge badge-dark">Dark</span>

        </li>
        <?php endforeach; ?>

        <li class="list-group-item">A second item</li>
    </ul>
    <div class="card-body">
        <a href="#" class="card-link">Card link</a>
        <a href="#" class="card-link">Another link</a>
    </div>
</div>
