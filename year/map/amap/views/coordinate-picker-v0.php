<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-1-12
 * Time: 下午1:05
 */
/* @var $this yii\web\View */
?>
<?php

// 引入artDialog 必须的js css
\app\widgets\ArtDialog::widget([
        'skin'=>\app\widgets\ArtDialog::SKIN_BLACK,
    ]);
?>
<?php  \year\widgets\JsBlock::begin() ?>
<script>
    $(function(){
       var options = <?= $options ?>;

       $(document).on('click',options.trigger,function(){
           art.dialog({
               title: '评论回复',
               width:800,
               height:800,
                content:$("#dialog-content").get(0)
               // url : 'http://zhaoziang.com/amap/picpoint.html'
           });
       }) ;
    });
</script>
<?php \year\widgets\JsBlock::end() ?>

<?= \year\widgets\IFrameAutoHeight::widget([
    'selector'=> '#amap-iframe'
]) ?>
<div id="dialog-content" style="display: none">

    <iframe width="700px" height="800" id="amap-iframe" src="<?= \yii\helpers\Url::to(['/sys/run-widget',
        'class'=>\year\map\amap\GeoCoordinatePicker::className(),
        'callback'=>$this->context->callback,
    ]) ?>">
    </iframe>
</div>
<script id="dialog-content-v0" type="html/x-template">
    <iframe src="<?= \yii\helpers\Url::to(['/sys/run-widget','class'=>\year\map\amap\GeoCoordinatePicker::className()]) ?>">
    </iframe>
</script>
