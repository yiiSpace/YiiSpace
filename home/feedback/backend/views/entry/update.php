<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model home\feedback\common\models\Feedback */

$this->title = '更新: ' . $model->subject;
$this->params['breadcrumbs'][] = ['label' => '信件列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->subject, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="feedback-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
