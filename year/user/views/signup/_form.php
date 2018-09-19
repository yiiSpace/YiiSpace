<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model year\user\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'icon_url')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'salt')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'last_login_ip')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'last_active_at')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
