
<div style="margin-top: 45px">

</div>


<div class="panel panel-<?= empty($tipBoxStyle)? 'info' : $tipBoxStyle  ?>">
    <div class="panel-heading">
        <h3 class="panel-title">

        </h3>
    </div>
    <div class="panel-body">
        <h1>
            <?php echo $msg; ?>
        </h1>


                系统将在 <span id='secs'><?php echo $secs ?></span> 秒后自动跳转，或者手动<a
                    href="javascript:history.back(-goBackStep);">返回</a>

    </div>
</div>


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
            history.back(-goBackStep);
        }
    }
</script>
