<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model year\status\models\Status */

$this->title = Yii::t('status', 'Update {modelClass}: ', [
    'modelClass' => 'Status',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('status', 'Statuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('status', 'Update');
?>
<div class="status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
