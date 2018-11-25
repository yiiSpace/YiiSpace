<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var my\content\common\models\Article $model
*/

$this->title = Yii::t('models', 'Article');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Article'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud article-update">

    <h1>
        <?= Yii::t('models', 'Article') ?>
        <small>
                        <?= Html::encode($model->title) ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
