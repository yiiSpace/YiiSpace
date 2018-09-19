<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model year\status\models\StatusSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="status-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'content') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'creator_id') ?>

    <?= $form->field($model, 'create_at') ?>

    <?php // echo $form->field($model, 'profile_id') ?>

    <?php // echo $form->field($model, 'approved') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('status', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('status', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
