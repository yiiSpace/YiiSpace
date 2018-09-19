<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var my\content\common\models\PhotoSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="photo-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?php // $form->field($model, 'id') ?>

		<?php // $form->field($model, 'owner_id') ?>

		<?php // $form->field($model, 'album_id') ?>
    <?= $form->field($model, 'album_id')
        ->dropDownList(['' => '全部相册'] + \my\content\common\models\Album::forPhotoDropDownSelection(), []) ?>

		<?= $form->field($model, 'title') ?>

		<?= $form->field($model, 'desc') ?>

		<?php // echo $form->field($model, 'uri') ?>

		<?php // echo $form->field($model, 'ext') ?>

		<?php // echo $form->field($model, 'size') ?>

		<?php // echo $form->field($model, 'hash') ?>

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
