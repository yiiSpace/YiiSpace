<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model year\status\models\Status */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="status-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => 120]) ?>

    <?= $form->field($model, 'creator_id')->textInput() ?>

    <?= $form->field($model, 'create_at')->textInput() ?>

    <?= $form->field($model, 'profile_id')->textInput() ?>

    <?= $form->field($model, 'approved')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('status', 'Create') : Yii::t('status', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
