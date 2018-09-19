<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model my\test\common\models\Msg */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msg-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uid')->textInput() ?>

    <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'snd_type')->textInput() ?>

    <?= $form->field($model, 'snd_status')->textInput() ?>

    <?= $form->field($model, 'priority')->textInput() ?>

    <?= $form->field($model, 'to_id')->textInput() ?>

    <?= $form->field($model, 'msg_pid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'sent_time')->textInput() ?>

    <?= $form->field($model, 'delete_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
