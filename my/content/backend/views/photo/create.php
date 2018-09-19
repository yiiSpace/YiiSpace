<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var my\content\common\models\Photo $model
*/

$this->title = Yii::t('models', 'Photo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Photos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud photo-create">

    <h1>
        <?= Yii::t('models', 'Photo') ?>
        <small>
                        <?= Html::encode($model->title) ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
