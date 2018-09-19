<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-1-12
 * Time: 下午1:05
 */
/* @var $this yii\web\View */
?>

<?php  \year\widgets\JsBlock::begin() ?>
<script>
    $(function(){
       var options = <?= $options ?>;

       $(document).on('click',options.trigger,function(){
          /*
           art.dialog({
               title: '评论回复',
               width:800,
               height:800,
                content:$("#dialog-content").get(0)
               // url : 'http://zhaoziang.com/amap/picpoint.html'
           });
           */
           var url = "<?= \yii\helpers\Url::to(['/sys/run-widget',
        'class'=>\year\map\amap\GeoCoordinatePicker::className(),
        'callback'=>$this->context->callback,
    ]) ?>"
          var win =   window.open(url,"newwindow", "height=700, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no ,z-look=yes");
          if(win){
                  win.focus();
          }
           return  false ;
       }) ;
    });
</script>
<?php \year\widgets\JsBlock::end() ?>
