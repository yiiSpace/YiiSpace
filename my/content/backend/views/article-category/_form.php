<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var my\content\common\models\ArticleCategory $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="article-category-form">

    <?php $form = ActiveForm::begin([
            'id' => 'ArticleCategory',
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


            <!-- attribute parent_id -->
            <?php // $form->field($model, 'parent_id')->textInput() ?>
            <?= $form->field($model, 'parent_id')->dropDownList(
                \my\content\common\models\ArticleCategory::getCategoryTreeOptions(), []) ?>

            <!-- attribute name -->
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <!-- attribute display_order -->
            <?= $form->field($model, 'display_order')->textInput() ?>

            <!-- attribute mbr_count -->
            <?= $form->field($model, 'mbr_count')->textInput() ?>

            <!-- attribute page_size -->
            <?= $form->field($model, 'page_size')->textInput() ?>

            <!-- attribute status -->
            <?= $form->field($model, 'status')->textInput() ?>


            <!-- attribute redirect_url -->
            <?= $form->field($model, 'redirect_url')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget(
            [
                'encodeLabels' => false,
                'items' => [
                    [
                        'label' => Yii::t('models', 'ArticleCategory'),
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

