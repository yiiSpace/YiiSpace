<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var my\content\common\models\Article $model
*/

$this->title = Yii::t('models', 'Article');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud article-create">

    <h1>
        <?= Yii::t('models', 'Article') ?>
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
