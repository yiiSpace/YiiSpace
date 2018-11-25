<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var my\content\common\models\PhotoSearch $searchModel
 * @var my\content\common\models\Album $album
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
$actionColumnTemplateString = '<div class="action-buttons">' . $actionColumnTemplateString . '</div>';
?>
<?php
// 注册yii js
\yii\web\YiiAsset::register($this);

?>
<div class="giiant-crud photo-index">

    <?php
    echo $this->render('_search', ['model' => $searchModel]);
    ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
            'modelClass' => '图片',
        ]), ['create', 'album_id' => $searchModel->album_id], ['class' => 'btn btn-success']) ?>
        <?php if ($album): ?>
            当前相册：  <?= $album->name ?>
        <?php endif; ?>
    </p>

    <?php /* ListView::widget([
    'dataProvider' => $dataProvider,
    'itemOptions' => ['class' => 'item'],
    'itemView' => function ($model, $key, $index, $widget) {
    return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
    },
    ]); */

    ?>

    <section
            data-featherlight-gallery
            data-featherlight-filter="a.thumbnail"
    >

        <?= \year\bootstrap\TbThumbListView::widget([
            'col' => 3,
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_view'
            /*
            function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
        }*/,
        ]) ?>


        <!--        <a href="photo_large.jpg"><img src="photo_thumbnail.jpg"></a>-->

    </section>

    <?php
    \year\widgets\featherlight\JFeatherlightGalleryAsset::register($this);
    \year\widgets\JsBlock::begin();
    ?>
    <script>
        $(document).ready(function () {
            $('.gallery').featherlightGallery();
        });
        $(function () {
            $(document).off('click','.photo-index a.ajax').on('click','.photo-index a.ajax', function (e) {
                e.preventDefault();

                var data = {};
                data[yii.getCsrfParam()] = yii.getCsrfToken();
                $.ajax({
                    // url: '<?php echo Yii::$app->request->baseUrl . '/supermarkets/sample' ?>'
                    url: $(this).attr('href'),
                    type: 'post',
                    data: data,
                    success: function (data) {
                        // console.log(data);
                        if (data.error == 0) {
                            alert('设置成功！');
                        }
                    }
                });

            });
        });
    </script>

    <?php \year\widgets\JsBlock::end() ?>


