<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm ;

/* @var $this yii\web\View */
/* @var $model year\status\models\Status */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="status-form">

    <?php $form = ActiveForm::begin([
      'layout'=>'inline',
      'options'=>[
          'data-pjax'=>'',
      ] ,

    ]); ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type')->hiddenInput(['maxlength' => 120]) ?>

    <?= $form->field($model, 'creator_id')->hiddenInput() ?>

    <?= $form->field($model, 'create_at')->hiddenInput() ?>

    <?= $form->field($model, 'profile_id')->hiddenInput() ?>

    <?= $form->field($model, 'approved')->hiddenInput() ?>

    <span class="glyphicon glyphicon-search"></span>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('status', 'Create') : Yii::t('status', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
