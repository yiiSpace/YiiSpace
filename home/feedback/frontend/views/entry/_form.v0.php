<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model home\feedback\common\models\Feedback */
/* @var $form yii\widgets\ActiveForm */
$actionId = Yii::$app->controller->action->id;
?>

<?php \year\widgets\CssBlock::begin() ?>
<style>
    _div.required input:after {
        content: "*";
        background-color: yellow;
        color: red;
        font-weight: bold;
    }

    _div.required > label:after {
        content: " *";
        color: red;
    }
</style>
<?php \year\widgets\CssBlock::end() ?>


<div class="feedback-form">

                    <div class="" style="padding: 8px 5px 8px 5px">

                        <?php $form = ActiveForm::begin([
                            'layout' => 'horizontal',
                            'fieldConfig' => [
//          'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                                'template' => "{label}\n{input}\n{error}",
                             //   'template' => "{label} <div class=\"row\"><div class=\"col-sm-6\">{input} {error}</div></div>",
                                // 'inputTemplate' => '<div class="input-group">{input}</div>  ',
                            ],
                        ]); ?>
                        <div class="row">
                            <div class="col-xs-4  ">

                            </div>
                            <div class="col-xs-8 ">

                            </div>
                        </div>


                        <?php //  $form->field($model, 'cate_id')->textInput() ?>

                        <?php if ($actionId != '2director'): ?>
                            <?= $form->field($model, 'type_id', [
                                'template' => "{label} <div class=\"row\"><div class=\"col-sm-8\">{input} {error}</div></div>",
                                // 'inputTemplate' => '{input}',
                            ])->inline()
                                ->radioList(\home\feedback\common\models\Feedback::getTypeOptions([\home\feedback\common\models\Feedback::TYPE_TO_DIRECTOR]), [

                                ])
                                ->hint(false) ?>
                            <?php else: ?>
                            <?= $form->field($model, 'type_id')->hiddenInput([
                                'value'=>\home\feedback\common\models\Feedback::TYPE_TO_DIRECTOR,
                            ])->label(false)->hint(false) ?>
                        <?php endif; ?>


                        <div class="row">
                            <div class="col-xs-4">
                                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-xs-8">
                                <?= $form->field($model, 'id_card')->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-xs-4">
                                <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-xs-8">

                                <?= $form->field($model, 'contact_address', [
                                    // 'template' => "{label} <div class=\"row\"><div class=\"col-sm-7\">{input} \n{error}  </div></div>"
                                ])->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-xs-4  ">
                                <?= $form->field($model, 'subject', [
                                    'template' => '{label} <div class="row"><div class="col-sm-7">{input}{error} </div></div>'
                                ])->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-xs-8 ">

                            </div>
                        </div>


                        <div class="row">
                            <div class="col-xs-8  ">
                                <?= $form->field($model, 'body', [
                                    'template' => '{label} <div class="row"><div class="col-sm-7">{input}{error} </div></div>'
                                ])->textarea(['rows' => 6]) ?>

                            </div>
                        </div>



                        <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className(), [
                            // 'captchaAction' => '/site/captcha',
                            'captchaAction' => ['captcha'],
                            'template' => '<div class="row"><div class="col-lg-6">{input}</div> <div class="col-lg-3">{image}</div></div>',
                        ]) ?>

                        <div class="hidden">
                            <?= $form->field($model, 'reply_department')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'reply_at')->textInput() ?>

                            <?= $form->field($model, 'reply_content')->textarea(['rows' => 6]) ?>

                            <?= $form->field($model, 'admin_updated_by')->textInput() ?>

                            <?= $form->field($model, 'status')->textInput() ?>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4">
                                    <?= Html::submitButton($model->isNewRecord ? '提交' : '更新',
                                        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                </div>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>




</div>
