<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="user-form" >

    <?php $form = ActiveForm::begin(
            [
                'options' => [
                    'class' => 'ui-form',
                     'id'=>'yiiActiveForm_user',
                    // 此处比较重要！yii默认会为没有id的widget生成id的 如果是ajax加载 会导致id冲突的 这样js中有些代码就失效了
                    // 这个最容易根search表单的id冲突  参考yiiActiveForm.js 源码就可以看出问题所在了！
                    // 'id'=>'form-'.time(),
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

    <?php echo $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'auth_key')->textInput(['maxlength' => 32]) ?>

    <?php echo $form->field($model, 'password_hash')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'password_reset_token')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'status')->textInput(['class'=>'easyui-textbox']) ?>

    </table>

    <div class="form-group" style="text-align:center;padding:5px">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success easyui-linkbutton' : 'btn btn-primary easyui-linkbutton']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
