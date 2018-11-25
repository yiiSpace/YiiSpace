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

    <section
            data-featherlight-gallery
            data-featherlight-filter="a"
    >
        <h>This is a gallery</h>
<!--        <a href="photo_large.jpg"><img src="photo_thumbnail.jpg"></a>-->
     <?php    foreach($dataProvider->getModels() as $model){
          echo Html::a(Html::img($model->getUrl()),$model->getUrl()) ;
        }
        ?>
    </section>

    <?php
    \year\widgets\featherlight\JFeatherlightGalleryAsset::register($this);
   \year\widgets\JsBlock::begin();
    ?>
    <script>
        $(document).ready(function(){
            $('.gallery').featherlightGallery();
        });
    </script>

    <?php \year\widgets\JsBlock::end() ?>

    <hr/ >

   

    <?=
    \powerkernel\photoswipe\Gallery::widget([
        'items' => [
            [
                'image' => 'https://c2.staticflickr.com/2/1518/24267732553_54aed33368_b.jpg',
                'title' => 'Image Title 1',
                'caption' => 'Caption 2',
                'size' => '1024x685',
                'thumb' => 'https://c2.staticflickr.com/2/1518/24267732553_54aed33368_m.jpg',
            ],
            [
                'image' => 'https://farm6.staticflickr.com/5023/5578283926_822e5e5791_b.jpg',
                'title' => 'Image Title 2',
                'caption' => 'Caption 3',
                'size' => '1024x768',
                'thumb' => 'https://farm6.staticflickr.com/5023/5578283926_822e5e5791_m.jpg',
            ],
        ]
    ])
    ?>


