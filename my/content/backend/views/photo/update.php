<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var my\content\common\models\Photo $model
*/

$this->title = Yii::t('models', 'Photo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Photo'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud photo-update">

    <h1>
        <?= Yii::t('models', 'Photo') ?>
        <small>
                        <?= Html::encode($model->title) ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
