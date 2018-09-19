<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var my\content\common\models\Photo $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="photo-form">

    <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],// important
            'id' => 'Photo',
            'layout' => 'horizontal',
            'enableClientValidation' => true,
            'errorSummaryCssClass' => 'error-summary alert alert-danger',
            'fieldConfig' => [
                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-2',
                    #'offset' => 'col-sm-offset-4',
                    'wrapper' => 'col-sm-8',
                    'error' => '',
                    'hint' => '',
                ],
            ],
        ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>


            <!-- attribute owner_id -->
            <?php // $form->field($model, 'owner_id')->textInput() ?>

            <!-- attribute album_id -->
            <?= $form->field($model, 'album_id')->textInput() ?>

            <!-- attribute desc -->
            <?= $form->field($model, 'desc')->textarea(['rows' => 6]) ?>

            <!-- attribute uri -->
            <?PHP
            // 修改时不出现此输入框
            if($model->getIsNewRecord()) echo $form->field($model, 'uri')->fileInput(['maxlength' => true]) ?>

            <!-- attribute title -->
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <!-- attribute ext -->
            <?php // $form->field($model, 'ext')->textInput(['maxlength' => true]) ?>

            <!-- attribute size -->
            <?php // $form->field($model, 'size')->textInput(['maxlength' => true]) ?>

            <!-- attribute hash -->
            <?php // $form->field($model, 'hash')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget(
            [
                'encodeLabels' => false,
                'items' => [
                    [
                        'label' => Yii::t('models', 'Photo'),
                        'content' => $this->blocks['main'],
                        'active' => true,
                    ],
                ]
            ]
        );
        ?>
        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? 'Create' : 'Save'),
            [
                'id' => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
            ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

