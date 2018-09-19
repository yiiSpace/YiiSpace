<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model year\status\models\Status */

$this->title = Yii::t('status', 'Create {modelClass}', [
    'modelClass' => 'Status',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('status', 'Statuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
