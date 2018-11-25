<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var my\content\common\models\PhotoSearch $searchModel
*/

$this->title = Yii::t('models', 'Photos');
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
<div class="giiant-crud photo-index">

    <?php
            echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
            'modelClass' => '图片',
        ]), ['create','album_id'=>$searchModel->album_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php /* ListView::widget([
    'dataProvider' => $dataProvider,
    'itemOptions' => ['class' => 'item'],
    'itemView' => function ($model, $key, $index, $widget) {
    return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
    },
    ]); */

    ?>

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



    <hr/ >

    // on your view
    <?php $items = [
        [
            'url' => 'http://farm8.static.flickr.com/7429/9478294690_51ae7eb6c9_b.jpg',
            'src' => 'http://farm8.static.flickr.com/7429/9478294690_51ae7eb6c9_s.jpg',
            'options' => array('title' => 'Camposanto monumentale (inside)')
        ],

    ];
    foreach($dataProvider->getModels() as $model){
        $items[] = [
          'url'=>$model->getUrl(),
          'src'=>$model->getUrl(),
          'options'=>[
                  'title'=>$model->title,
          ]
        ];
    }
    ?>
    <?= dosamigos\gallery\Gallery::widget(['items' => $items]);?>



