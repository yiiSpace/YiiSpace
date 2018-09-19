<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var my\content\common\models\Album $model
*/

$this->title = Yii::t('models', 'Album');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Albums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud album-create">

    <h1>
        <?= Yii::t('models', 'Album') ?>
        <small>
                        <?= Html::encode($model->name) ?>
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
