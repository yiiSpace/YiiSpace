<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminMenu */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="admin-menu-form" >

    <?php $form = ActiveForm::begin(
            [
                'options' => [
                'class' => 'ui-form',
            ],
            'fieldConfig' => [
                'template' => "<td>{label}</td>\n<td>{input}</td>\n<td>{error}</td>",
                //  'template' => "{input} \n {error}",
                // 'labelOptions' => ['class' => 'ui-label'],
                // 'inputOptions' => ['class' => 'ui-input'],
                'options' => ['tag' => 'tr'],
                 ],
            ]
    ); ?>

    <?php $form->errorSummary($model); ?>

    <table>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => 60]) ?>

    <?php echo $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'icon')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'icon_type')->textInput(['class'=>'easyui-textbox']) ?>

    <?php echo $form->field($model, 'active')->textInput(['class'=>'easyui-textbox']) ?>

    <?php echo $form->field($model, 'selected')->textInput(['class'=>'easyui-textbox']) ?>

    <?php echo $form->field($model, 'disabled')->textInput(['class'=>'easyui-textbox']) ?>

    <?php echo $form->field($model, 'readonly')->textInput(['class'=>'easyui-textbox']) ?>

    <?php echo $form->field($model, 'visible')->textInput(['class'=>'easyui-textbox']) ?>

    <?php echo $form->field($model, 'collapsed')->textInput(['class'=>'easyui-textbox']) ?>

    <?php echo $form->field($model, 'movable_u')->textInput(['class'=>'easyui-textbox']) ?>

    <?php echo $form->field($model, 'movable_d')->textInput(['class'=>'easyui-textbox']) ?>

    <?php echo $form->field($model, 'movable_l')->textInput(['class'=>'easyui-textbox']) ?>

    <?php echo $form->field($model, 'movable_r')->textInput(['class'=>'easyui-textbox']) ?>

    <?php echo $form->field($model, 'removable')->textInput(['class'=>'easyui-textbox']) ?>

    <?php echo $form->field($model, 'removable_all')->textInput(['class'=>'easyui-textbox']) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    </table>

    <?php ActiveForm::end(); ?>

</div>
