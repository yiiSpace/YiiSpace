- easydropdown 美化下拉列表
  https://github.com/patrickkunka/easydropdown

~~~html

使用easydropdown固定需要三个文件：easydropdown.css、jquery.easydropdown.js、jquery-2.0.3.min.js

html 中 使用样式（class="dropdown"）：

<select name="tm_type_select" id="tm_type_select" class="dropdown" value="" onchange="selectTmType()">
   <option value="" >题目类型</option>
</select>


js通过ajax获取数据后，加入下拉框中，再调用easydropdown事件：

success : function(result) {
   var html = "";
   for(var i in result ){
      html += "<option value='" + i + "'>" + result[i] + "</option>"
   }
   $("#tm_type_select").append(html);
   $("#tm_type_select").easyDropDown("destroy"); // 必不可少,因为前端样式已经变成ul和li了，所以必须先销毁一遍.
   $("#tm_type_select").easyDropDown();
},
--------------------- 
作者：Liu_Bu 
来源：CSDN 
原文：https://blog.csdn.net/tiezhu_tiemei/article/details/78259758 
版权声明：本文为博主原创文章，转载请附上博文链接！

~~~

- 浏览器端处理分页
使用jquery pagination 插件
https://github.com/superRaytin/paginationjs/blob/master/examples/pagination.html

Yii ajax化分页：

~~~php

 /*
        // 搜索表单提交
        $(".goods-selection-submit").on('click', function () {
            var url = '<?= \yii\helpers\Url::to(['goods-selection']) ?>';
            var params = $("form[name='goods-selection-form']").serialize();

            $(".selection-source").html('请等待....<i class="glyphicon glyphicon-repeat"></i> ');
            $.get(url, params, function (resp) {
                $(".selection-source").html(resp);
            });
        });
        */
// 分页ajax化
        var pagerLinkSelector = 'div.ui-paging a.ui-paging-item ';  // 默认的yii分页类 "ul.pagination a"
        $(document).on('click', pagerLinkSelector, function (e) {
            $(".list-view").html('请等待....<i class="glyphicon glyphicon-repeat"></i> ');
            $.get($(this).attr("href"),function(resp){
                var $respContent = $("<div>"+resp+"</div>");
                $(".list-view").replaceWith($respContent.find('.list-view'));
            });
            return false;
        });

        // 选择图片
        $(document).on('click','.store-img-pool img',function(e){
            // alert($(this).attr('src'));
            callback($(this).attr('src'));
        });
~~~

- 添加 migrations 执行功能 
比如 module/install         为模块安装提供“迁移”类 执行的能力

- 在线编辑器的可替换性
可以使用不同的编辑器 带来不同的用户体验  比如 redactor wangEditor  