<?php $this->beginPage() ?>
<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--    <title>酸奶小妹的火星坐标</title>-->
    <title>百度坐标</title>
<!--    <script language="javascript" src="http://webapi.amap.com/maps?v=1.2&key=c84af8341b1cc45c801d6765cda96087"></script>-->
    <style>
        #allmap{
            height:600px;
            width:800px;
            float:left;
        }
        .info{
            float:left;
            margin:0 0 0 10px;
        }
        label{
            width:80px;
            float:left;
        }
        .detail{
            padding:10px;
            border:1px solid #aaccaa
        }
    </style>
    <?php $this->head() ?>
</head>
<body onLoad="">
<?php $this->beginBody() ?>

<?= \year\map\baidu\BMap::widget(); ?>
<div id="allmap"></div>
<div class="info">
    <h1>坐标拾取工具（GCJ-02坐标）</h1>
    <p>说明：</p>
    <p>1、鼠标滚轮可以缩放地图，拖动地图。</p>
    <p>2、点击地图，即可获得GCJ-02的经纬度坐标，即火星坐标。</p>
    </br>
    <div class="detail">
        <p><span id="lnglat">&nbsp;</span></p>
        <p><span id="iAddress">&nbsp;</span></p>
    </div>
</div>
</body>
<?php $this->endBody() ?>
<script language="javascript">

    // 百度地图API功能
    var map = new BMap.Map("allmap");

    map.centerAndZoom("常州",12);
    map.setDefaultCursor("url('bird.cur')");   //设置地图默认的鼠标指针样式

    map.enableScrollWheelZoom();   //启用滚轮放大缩小，默认禁用
    map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用

    // 逆地址解析器
    var geoc = new BMap.Geocoder();

    map.addEventListener("click", showInfo);

    function showInfo(e){
       // alert(e.point.lng + ", " + e.point.lat);
        getLnglat(e);
    }
    // php 中传递过来的参数 回调方法名称
    var options = <?= $options  ?>

    //鼠标点击，获取经纬度坐标
    function getLnglat(e){

        var x = e.point.lng;
        var y =  e.point.lat;
        /*
        alert(e.point.lng + ", " + e.point.lat);
        alert("选择成功！");
        */
        // alert(e.point.lng + ", " + e.point.lat);
        var pt = e.point;
        geoc.getLocation(pt, function(rs){
            var addComp = rs.addressComponents;
            alert(addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber);

            // 转换为GCJ-02 编码
            var geoGCJ = GPS.bd_decrypt(y,x);
            y = geoGCJ['lat'];
            x = geoGCJ['lng'];

            if(window.opener){
                window.opener[options.callback].call(null,x,y);
                window.openner=null;
                window.close();
            }else{
                top[options.callback].call(null,x,y);
            }

        });



    }
</script>
</html>
<?php $this->endPage() ?>