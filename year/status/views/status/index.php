<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel year\status\models\StatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('status', 'Statuses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('status', 'Create {modelClass}', [
    'modelClass' => 'Status',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
        },
    ]) ?>

</div>
