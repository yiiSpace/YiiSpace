<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var my\content\common\models\AlbumSearch $searchModel
*/

$this->title = Yii::t('models', 'Albums');
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
?>
<div class="giiant-crud album-index">

    <?php
            echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php /*  ListView::widget([
    'dataProvider' => $dataProvider,
    'itemOptions' => ['class' => 'item'],
    'itemView' => function ($model, $key, $index, $widget) {
    return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
    },
    ]);  */?>

    <?= \year\bootstrap\TbThumbListView::widget([
        'col'=>3,
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_view'
        /*
        function ($model, $key, $index, $widget) {
        return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
    }*/,
    ]) ?>

