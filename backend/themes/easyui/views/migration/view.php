<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Migration */

$this->title = $model->version;
$this->params['breadcrumbs'][] = ['label' => 'Migrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="migration-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->version], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->version], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'version',
            'apply_time:datetime',
        ],
    ]) ?>

</div>
