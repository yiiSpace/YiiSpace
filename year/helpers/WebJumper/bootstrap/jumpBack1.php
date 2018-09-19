<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<html>
<head>

    <title></title>

</head>
<body>

<div>
    <h1>
        <?php echo $msg;?>
    </h1>
    <div>
        <h2>
            系统将在 <span id='secs'><?php echo $secs ?></span> 秒后自动跳转，或者手动<a href="javascript:history.back(-goBackStep);">返回</a>
        </h2>
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
            history.go(-goBackStep);
        }
    }
</script>

</body>
</html>