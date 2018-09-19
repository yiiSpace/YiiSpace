<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model home\feedback\common\models\Feedback */
/* @var $form yii\widgets\ActiveForm */
?>
<?php \year\widgets\CssBlock::begin() ?>
<style>
    .row{
        margin-top:40px;
        padding: 0 10px;
    }

    .clickable{
        cursor: pointer;
    }

    .panel-heading span {
        margin-top: -20px;
        font-size: 15px;
    }
</style>
<?php \year\widgets\CssBlock::end() ?>

<?php \year\widgets\JsBlock::begin() ?>
<script>
    $(document).on('click', '.panel-heading span.clickable', function(e){
        var $this = $(this);
        if(!$this.hasClass('panel-collapsed')) {
            $this.parents('.panel').find('.panel-body').slideUp();
            $this.addClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
        } else {
            $this.parents('.panel').find('.panel-body').slideDown();
            $this.removeClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
        }
    })
</script>
<?php \year\widgets\JsBlock::end() ?>

<div class="feedback-form">

    <?php $form = ActiveForm::begin([
        // 'layout'=>'horizontal',
        'fieldConfig' => [
//          'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'template' => "{label}\n{input}\n{error}",

        ],
    ]); ?>


    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">来信</h3>
            <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
        </div>
        <div class="panel-body">

            <?php // $form->field($model, 'cate_id')->textInput() ?>

            <?= $form->field($model, 'type_id')->inline()->radioList(\home\feedback\common\models\Feedback::getTypeOptions(), []) ?>

            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'id_card')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'contact_address')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

        </div>
    </div>

    <?php /* $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className(), [
        'captchaAction'=>'/site/captcha',
        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
    ]) */ ?>

    <div class="panel panel-warning">
        <div class="panel-heading">
            <h3 class="panel-title">回复</h3>
            <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
        </div>
        <div class="panel-body">

            <?= $form->field($model, 'reply_department')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'reply_at')->textInput() ?>

            <?= $form->field($model, 'reply_content')->textarea(['rows' => 6]) ?>

            <?php  // $form->field($model, 'status')->dropDownList(\home\feedback\common\models\Feedback::getStatusOptions()) ?>

            <?= $form->field($model, 'status')->inline()
                ->radioList(\home\feedback\common\models\Feedback::getStatusOptions())
                ->hint(false) ?>

        </div>
    </div>


    <div class="hidden">
        <?= $form->field($model, 'admin_updated_by')->textInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
