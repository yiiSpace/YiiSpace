<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminMenu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 60]) ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'icon_type')->textInput() ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?= $form->field($model, 'selected')->textInput() ?>

    <?= $form->field($model, 'disabled')->textInput() ?>

    <?= $form->field($model, 'readonly')->textInput() ?>

    <?= $form->field($model, 'visible')->textInput() ?>

    <?= $form->field($model, 'collapsed')->textInput() ?>

    <?= $form->field($model, 'movable_u')->textInput() ?>

    <?= $form->field($model, 'movable_d')->textInput() ?>

    <?= $form->field($model, 'movable_l')->textInput() ?>

    <?= $form->field($model, 'movable_r')->textInput() ?>

    <?= $form->field($model, 'removable')->textInput() ?>

    <?= $form->field($model, 'removable_all')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
