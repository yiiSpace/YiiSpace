<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model home\feedback\common\models\FeedbackSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php \year\widgets\CssBlock::begin() ?>
    <style>
        .bs-example, .feedback-search_v0 {
            /* margin-right: 0; */
            /* margin-left: 0; */
            /* background-color: #fff; */
            /* border-color: #ddd; */
            /* border-width: 1px; */
            /* border-radius: 4px 4px 0 0; */
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .feedback-search_v0 {
            position: relative;
            padding: 15px 15px 15px;
            margin: 0 -15px 15px;
            border-color: #e5e5e5 #eee #eee;
            border-style: solid;
            border-width: 1px 0;
            -webkit-box-shadow: inset 0 3px 6px rgba(0, 0, 0, .05);
            box-shadow: inset 0 3px 6px rgba(0, 0, 0, .05);
        }

        .feedback-search form {
        }
    </style>
<?php \year\widgets\CssBlock::end() ?>

    <div class="feedback-search">

        <?php $form = ActiveForm::begin([
            'layout' => 'inline',
            'action' => ['index'],
            'method' => 'get',
            'fieldConfig' => [
//          'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                'template' => "{label}\n{input}\n{error}",
                'inputOptions' => [
                    'class' => 'form-control input-sm',
                ],

                'options'=>[
                   'class'=>'form-group  col-xs-10 ' ,
                ],
            ],
        ]); ?>

        <?php // $form->field($model, 'id') ?>

        <?php echo $form->field($model, 'subject', [
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('subject'),
                'style'=>'margin-left:-11px',
            ]
        ]) ?>

        <?php // $form->field($model, 'username') ?>

        <?php // $form->field($model, 'id_card') ?>
        <?php
        use dosamigos\datepicker\DateRangePicker;

        ?>
        <?php /* $form->field($model, 'date_from')->widget(DateRangePicker::className(), [
            'options' => [
                'placeholder' => '请选择起始时间'
            ],
            'optionsTo' => [
                'placeholder' => '截止时间'
            ],
            'labelTo' => '至',
            'attributeTo' => 'date_to',
            'form' => $form, // best for correct client validation
            'language' => 'zh-CN',
            'size' => 'md', // ('lg', 'md', 'sm', 'xs')
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);  */ ?>

        <?php // $form->field($model, 'cate_id') ->dropDownList() ?>



        <?php // echo $form->field($model, 'tel') ?>

        <?php // echo $form->field($model, 'contact_address') ?>




        <?php // echo $form->field($model, 'body') ?>

        <?php // echo $form->field($model, 'reply_department') ?>

        <?php // echo $form->field($model, 'reply_at') ?>

        <?php // echo $form->field($model, 'reply_content') ?>

        <?php // echo $form->field($model, 'admin_updated_by') ?>

        <?php // echo $form->field($model, 'created_at') ?>

        <?php // echo $form->field($model, 'updated_at') ?>

        <?php // echo $form->field($model, 'status') ?>


        <div class="hidden">
            <?php echo $form->field($model, 'type_id')->dropDownList(\home\feedback\common\models\Feedback::getTypeOptions([\home\feedback\common\models\Feedback::TYPE_TO_DIRECTOR]), [
            'prompt' => '请选择',
        ])  ?>
            <?php  echo $form->field($model, 'hot_grade')->hiddenInput()->label(false)->hint(false) ; ?>
        </div>

        <div class="form-group pull-right">
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('全部', ['class' => 'btn btn-default', 'onclick' => 'resetSearchInputs(this);return false ;']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
<?php \year\widgets\JsBlock::begin() ?>
    <script>
        // reset 会记录初始输入的
        function resetSearchInputs(resetBtn) {
            /*
             var $inputs = $('div.input-group.input-daterange').find(':input');
             $.each( $inputs ,function (idx, el) {
             console.log(el) ;
             alert($(el).val()) ;
             });
             */
            // $(resetBtn).closest('form').find('input[type=text], textarea').val('');
            // $(resetBtn).closest('form').trigger('reset');;
            var $searchForm = $(resetBtn).closest('form');
            $searchForm.find(':input').val("");
            $searchForm.trigger('submit') ;
        }
    </script>
<?php \year\widgets\JsBlock::end() ?>