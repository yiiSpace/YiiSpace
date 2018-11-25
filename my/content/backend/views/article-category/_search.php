<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var my\content\common\models\ArticleCategorySearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="article-category-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'parent_id') ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'display_order') ?>

		<?= $form->field($model, 'mbr_count') ?>

		<?php // echo $form->field($model, 'page_size') ?>

		<?php // echo $form->field($model, 'status') ?>

		<?php // echo $form->field($model, 'redirect_url') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

		<?php // echo $form->field($model, 'created_by') ?>

		<?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
