<div class="text-center" style="margin-top: 100px;line-height: 40px">
    <h1>
        <?php echo $msg;?>
    </h1>
    <p>
        系统将在 <span id='secs'><?php echo $secs ?></span> 后自动跳转，
        或者手动<a href="javascript:window.location.href='<?php echo $url; ?>';">跳转</a>
    </p>
</div>

<script language='javascript' type='text/javascript'>
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
           // history.go(-1);
            var newHref = '<?php echo $url; ?>';
           window.location.href = newHref;
	       window.navigate(newHref);
           self.location = newHref;
           top.location = newHref;

        }
    }
</script>