<?php

use year\bootstrap\TbThumbListView;
use year\widgets\ColumnListView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?=
      //ListView::widget([
//    ColumnListView::widget([
    TbThumbListView::widget([
        'col'=>2,
        'dataProvider' => $dataProvider,
        'options' => [
            'tag' => 'div',
            'class' => 'list-wrapper',
            'id' => 'list-wrapper',
        ],
        'layout' => "{summary}\n {pager}\n{items}\n{summary}\n <div class='row clearfix'> {pager} </div> ",
        'itemOptions' => ['class' => 'item'],
//        'itemView'=> '_list_item' ,
        'itemView' => function ($model, $key, $index, $widget) {
//            return Html::a(Html::encode($model['id'], ['view', 'id' => $model['id']]));
            // return dump($model) ;
               return $this->render('_list_item',['model' => $model]);
        },
        'pager' => [
            'firstPageLabel' => '首页',
            'lastPageLabel' => '最后一页',
            'nextPageLabel' => '下页',
            'prevPageLabel' => '前页',
            'maxButtonCount' => 5,
        ],
    ]) ?>


</div>