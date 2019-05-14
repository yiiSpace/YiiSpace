<?php
/* @var $this \yii\web\View */
/* @var $context \year\gii\common\widgets\PathSelector */
$context = $this->context ;

?>
<div class="module-form">

    <?php

    echo \yii\helpers\Html::a('选择路径 ', '#', [
        'id' => 'create',
        'class' => 'btn btn-success dialog-choose-path',
    ]);

    ?>

</div>
<?php
//if(!Yii::$app->getAssetManager()->getAssetUrl())
// \year\layui\LayerAsset::register($this) ?>
<?php \year\widgets\JsBlock::begin() ?>
<script>

    $(document).on('click','.dialog-choose-path',function (e) {


         layer.open({
             // type: 1,
             type: 2,
             skin: 'layui-layer-rim', //加上边框
             area:  ['60%', '70%'], //宽高
             content: '<?= \yii\helpers\Url::to(['//file-tree/home']) ?>'
         });

        //layer.alert('内容')
    });

</script>
<?php \year\widgets\JsBlock::end() ?>