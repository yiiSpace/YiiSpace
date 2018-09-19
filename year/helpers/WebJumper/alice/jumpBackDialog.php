<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'navSelectDialog',
    'options' => array(
        'title' => Yii::t('app', '提示！'),
        'autoOpen' => true,
        'modal' => 'true',
        'width' => '450',
        'height' => '300',
        'draggable' => true,
        'resizable' => true,
    ),
));?>

<div>
    <h1>
        <?php echo $msg;?>
    </h1>
    <div>
         <h6>
             系统将在 <span id='secs'><?php echo $secs ?></span> 秒后自动跳转，或者手动<a href="javascript:history.back(-goBackStep);">返回</a>
         </h6>
    </div>
</div>


<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>


<script language='javascript' type='text/javascript'>
    var goBackStep = <?php echo $step ; ?>;

    var totalSec = 5;
    var remainSec = 0;

    var secDisplay = document.getElementById("secs");
    var timer = self.setInterval("timeCount()", totalSec * 100);// = setTimeout("timedCount()",1000);

    function timeCount() {
        if (remainSec < 5) {
            secDisplay.innerHTML = totalSec - remainSec;
            remainSec = remainSec + 1;
        } else {
            clearInterval(timer);
            history.go(-goBackStep);
        }
    }
</script>