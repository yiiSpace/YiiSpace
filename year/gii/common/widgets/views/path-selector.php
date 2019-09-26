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
        'data'=>[
           // TODO 后期可以携带标识数据
            'from'=>$from
        ],
    ]);

    ?>

</div>
<?php
//if(!Yii::$app->getAssetManager()->getAssetUrl())
// \year\layui\LayerAsset::register($this) ?>
<?php \year\widgets\JsBlock::begin() ?>
<script>

    $(document).on('click','<?= $triggerSelector ?>',function (e) {

        var extData = $(this).data('from') ;
        // todo 先提取当前选择符上的data 部分需要的数据 然后原封不动传递到url去

         layer.open({
             // type: 1,
             type: 2,
             skin: 'layui-layer-rim', //加上边框
             area:  ['60%', '70%'], //宽高
             content: '<?= \yii\helpers\Url::to(['//file-tree/home']) ?>',
             success: function(layero, index){
                 var body = layer.getChildFrame('body', index);
                 // var iframeWin = window[layero.find('iframe')[0]['name']]; //得到iframe页的窗口对象，执行iframe页的方法：iframeWin.method();
                 // iframe内容注入 信息传递手段而已 也可以用url cookie postMessage等  但也需要相应的信息提取方式 增加负担
                 $(body).find("#fileTreeFrom").html(""+extData);
             }
         });

        //layer.alert('内容')
    });

</script>
<?php \year\widgets\JsBlock::end() ?>