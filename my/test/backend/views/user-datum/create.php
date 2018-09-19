<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var my\test\common\models\UserDatum $model
*/

$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = ['label' => $model->getAliasModel(true), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud user-datum-create">

    <h1>
        <?= $model->getAliasModel() ?>        <small>
                        <?= $model->user_id ?>        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            Yii::t('app', 'Cancel'),
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
