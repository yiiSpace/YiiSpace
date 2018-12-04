<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model my\devtools\common\models\ApiProvider */
/* @var $form ActiveForm */
?>
<div class="api-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'tableName') ?>
    <?= $form->field($model, 'tableName')
        ->listBox(\my\devtools\common\models\ApiProvider::getTableNameOptions(),['size'=>'16']) ?>
    <?= $form->field($model, 'modelName') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- api-form -->

