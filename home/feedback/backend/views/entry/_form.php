<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model home\feedback\common\models\Feedback */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="feedback-form">

    <?php $form = ActiveForm::begin([
        // 'layout'=>'horizontal',
        'fieldConfig' => [
//          'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'template' => "{label}\n{input}\n{error}",

        ],
    ]); ?>

   <?php $this->beginBlock('feedback_info') ?>
    <div class="panel panel-info feedback_info">

        <div class="panel-body">

            <?php // $form->field($model, 'cate_id')->textInput() ?>

            <?= $form->field($model, 'type_id')->inline()->radioList(\home\feedback\common\models\Feedback::getTypeOptions(), []) ?>

            <div class="row">
                <div class="col-xs-6">
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-xs-6">
                    <?= $form->field($model, 'id_card')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-xs-6">
                    <?= $form->field($model, 'contact_address')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

        </div>
    </div>
    <?php $this->endBlock() ?>
    <?php /* $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className(), [
        'captchaAction'=>'/site/captcha',
        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
    ]) */ ?>


    <?php $this->beginBlock('feedback_reply') ?>
    <div class="panel panel-warning">

        <div class="panel-body">

            <?= $form->field($model, 'reply_department')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'reply_at')->textInput() ?>

            <?= $form->field($model, 'reply_content')->textarea(['rows' => 6]) ?>

            <?php  // $form->field($model, 'status')->dropDownList(\home\feedback\common\models\Feedback::getStatusOptions()) ?>



            <div class="row">
                <div class="col-xs-6">
                    <?= $form->field($model, 'status')->inline()
                        ->radioList(\home\feedback\common\models\Feedback::getStatusOptions())
                        ->hint(false) ?>
                </div>
                <div class="col-xs-6">
                    <?= $form->field($model, 'hot_grade')->checkbox(['1'=>'热门'])->inline()
                        ->hint(false) ?>
                </div>
            </div>

        </div>
    </div>
     <?php $this->endBlock() ?>

    <div class="hidden">
        <?= $form->field($model, 'admin_updated_by')->textInput() ?>
    </div>


    <?php


    echo \yii\bootstrap\Tabs::widget([
        'items' => [
            [
                'label' => '来信',
                'content' => $this->blocks['feedback_info'],
                'active' => true
            ],
            [
                'label' => '回复',
                'content' => $this->blocks['feedback_reply'],
                'headerOptions' => [],
                'options' => ['id' => 'myveryownID'],
            ],

        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php \year\widgets\JsBlock::begin() ?>
    <script>
        $(function () {
            // @see http://stackoverflow.com/questions/7419383/make-field-readonly-checkbox-jquery
           // $('.feedback_info :input').attr('readonly', true);
           $('.feedback_info :input').prop('readonly', true);
           $('.feedback_info :input').attr('disabled', 'disabled');
        });
    </script>
<?php \year\widgets\JsBlock::end() ?>