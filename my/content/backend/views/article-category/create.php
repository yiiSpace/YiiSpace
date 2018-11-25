<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var my\content\common\models\ArticleCategory $model
*/

$this->title = Yii::t('models', 'Article Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Article Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud article-category-create">

    <h1>
        <?= Yii::t('models', 'Article Category') ?>
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
