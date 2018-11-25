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
<div class="giiant-crud photo-selection">

    <?php
    echo $this->render('_search', ['model' => $searchModel]);
    ?>

    <p>
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
            $(document).off('click','.photo-selection a.ajax').on('click','.photo-selection a.ajax', function (e) {
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
        $(function () {
            // 搜索表单提交
            $( ":submit" , ".editor-selection").on('click', function () {
                var $searchForm = $(this).closest('form') ;
                var url = $searchForm.attr('action');
                var params = $searchForm.serialize();

            $(".photo-selection").html('请等待....<i class="glyphicon glyphicon-repeat"></i> ');
            $.get(url, params, function (resp) {
                $(".photo-selection").html(resp);
            });
        });
            // 分页ajax化
            var pagerLinkSelector = 'div.ui-paging a.ui-paging-item ';  // 默认的yii分页类 "ul.pagination a"
            $(document).on('click', pagerLinkSelector, function (e) {
                var $listView = $(this).closest('.list-view') ;
                $listView.html('请等待....<i class="glyphicon glyphicon-repeat"></i> ');
                $.get($(this).attr("href"),function(resp){
                    var $respContent = $("<div>"+resp+"</div>");
                    $listView.replaceWith($respContent.find('.list-view'));
                });
                return false;
            });

            // 选择图片
            // $(document).on('click','.store-img-pool img',function(e){
            //     // alert($(this).attr('src'));
            //     callback($(this).attr('src'));
            // });
        });
    </script>

    <?php \year\widgets\JsBlock::end() ?>


