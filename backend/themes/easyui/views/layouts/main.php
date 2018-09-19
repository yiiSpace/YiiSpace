<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
// EasyuiAsset::register($this);

use sansusan\easyui\EasyuiAsset;

EasyuiAsset::register($this,
    [
        // 'theme' => 'metro-gray',
        'theme' => 'default',
        'locale' => 'easyui-lang-zh_CN'],
    ['datagrid-groupview']
);
// 里面有防止重复加载js的实现 很重要哦！ 特别是对于ajax 加载表单js
\yii\web\YiiAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <?php // \year\web\CSRF4Ajax::widget() ?>

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>
<body class="easyui-layout" style="text-align:left">

<div data-options="region:'north',border:false" style="height:60px;background:#B3DFDA;padding:10px">

    <h1>
        <?= '&nbsp;' . Html::encode($this->title) ?>
        <small><?php echo \Yii::$app->controller->id . '-' . \Yii::$app->controller->action->id; ?></small>
    </h1>
    <?php
    $breadcrumbs = isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [];
    foreach (Yii::$app->controller->modules as $module) {
        if ($module != Yii::$app) {
            array_unshift($breadcrumbs, ['label' => \yii\helpers\Inflector::camel2words($module->id), 'url' => ['/' . $module->uniqueId]]);
        }
    }
    ?>
    <?=
    Breadcrumbs::widget([
        'tag' => 'ol',
        'encodeLabels' => false,
        'homeLink' => ['label' => '<i class="fa fa-dashboard"></i> Home/Dashboard', 'url' => ['/site/index']],
        'links' => $breadcrumbs,
    ])
    ?>

</div>
<div data-options="region:'west',split:true,title:'West'" style="width:200px;padding:5px;">

    <div class="easyui-accordion" data-options="fit:true">

        <div title="About" style="padding:5px;">
            <h3 style="color:#0099FF;">Accordion for jQuery</h3>

            <p>Accordion is a part of easyui framework for jQuery. It lets you define your accordion component on web
                page more easily.</p>
        </div>
        <div title="Title1" data-options="selected:true" style="padding:5px">
            <ul class="easyui-tree">
                <li>
                    <span>Folder</span>
                    <ul>
                        <li>
                            <span>Sub Folder 1</span>
                            <ul>
                                <li>
                                    <span>File 11</span></li>
                                <li><span>File 12</span></li>
                                <li><span>File 13</span></li>
                            </ul>
                        </li>
                        <li><span>File 2</span></li>
                        <li><span>File 3</span></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="easyui-linkbutton" onclick="addTab('google','http://www.google.com')">google</a>
                </li>
                <li>
                    <a href="#" class="easyui-linkbutton" onclick="addTab('jquery','http://jquery.com/')">jquery</a>
                </li>
                <li>
                    <a href="#" class="easyui-linkbutton" onclick="addTab('easyui','http://jeasyui.com/')">easyui</a>
                </li>
                <li>
                    <a href="#" class="easyui-linkbutton"
                       onclick="addTab('easyui','<?= \yii\helpers\Url::to(['/admin-menu']) ?>')">admin-menu-test</a>
                </li>
                <li>
                    <a href="#" class="easyui-linkbutton"
                       onclick="addTab('easyui','<?= \yii\helpers\Url::to(['/user']) ?>')" data-route="/user">user</a>
                </li>

                <li>
                    <a href="#" class="easyui-linkbutton"
                       onclick="addTab('migration','<?= \yii\helpers\Url::to(['/migration']) ?>')" data-route="/migration">migration</a>
                </li>
            </ul>

        </div>
        <div title="Title2" style="padding:5px">
            <p>Content2</p>
        </div>
    </div>

</div>

<div data-options="region:'east',split:true,collapsed:true,title:'East'" style="width:100px;padding:10px;">
    east region
</div>

<div data-options="region:'south',collapsed:true,border:false" style="height:50px;background:#A9FACD;padding:10px;">
    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>
</div>

<div data-options="region:'center',title:'Center'">
    <div class="easyui-layout" data-options="fit:true">
        <div region="center">
            <div id="tt" class="easyui-tabs" style="width:100%;height:1154px;">
                <div title="Home">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!--TODO 在父窗体中完成crud的算法设计  需要的交互钩子留给iframe 子窗体完成，此是《模板方法》的思路 ，需要的东西子窗体用匿名方法注入到父窗体留的钩子参数中-->
<!-- 由于iframe的缘故 居中可能位置偏下了  style="width:400px;height:280px;padding:10px 20px"  可用top控制位置-->
<div id="dlg" class="easyui-dialog" style="width:560px;height:380px;padding:10px 20px; top:120px"
     closed="true" buttons="#dlg-buttons"
     data-options="onResize:function(){
             $(this).dialog('center');
        }"
    >
    <div id="ajax_form">稍等......</div>
</div>
<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6"
       iconCls="icon-ok" onclick="" style="width:90px" id="save_ajax_form">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton"
       iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
</div>


<!--高级搜索表单对话框-->
<div id="dlg_adv_search" class="easyui-dialog" style="width:560px;height:380px;padding:10px 20px; top:120px"
     closed="true" buttons="#dlg_adv_search_buttons"
     data-options="onResize:function(){
             $(this).dialog('center');
        }"
    >
    <div id="adv_search_form">稍等......</div>
</div>
<div id="dlg_adv_search_buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6"
       iconCls="icon-ok" onclick="" style="width:90px" id="do_adv_search">搜索</a>
    <a href="javascript:void(0)" class="easyui-linkbutton"
       iconCls="icon-cancel" onclick="javascript:$('#dlg_adv_search').dialog('close')" style="width:90px">取消</a>
</div>

<?php \year\widgets\JsBlock::begin() ?>
<script>

    /**
     * 改对象使用了模版设计模式的思维  在parent窗体中完成算法主体 缺失的步骤 由各个child 在调用时传递补全算法片段（闭包完成上下文空间的隔离）
     *
     * TODO  对话框的标题 也可以通过子窗体传入！
     * */
    var easyCrud = (function () {
        var pub = {
            // 对话框标题 可以在子iframe中设置哦  但边缘效应 如果忘记设置 会保持为上次使用的标题！
            // TODO 暂时未实现此特征  变相地：也可以在子类调用时 通过方法注入进来
            dialogOptions: {},
            defaultDialogOptions: {},

            init: function () {
                // 注册确定按钮的回调事件:
                $("#save_ajax_form").off('click').on('click', function () {
                    saveAjaxForm();
                });
                // 注册高级搜索表单确定按钮
                $("#do_adv_search").off('click').on('click', function () {
                    doAdvSearch();
                });

            },
            create: createOrUpdate,
            update: createOrUpdate,
            // delete 是关键字 不能命名为delete！
            del: function (url, params, callback) {
                $.post(url, params, function (rsp) {
                    if (rsp.status == 'success') {
                        msgAlert(rsp.msg);

                        // 重新加载数据表格 如果必要可以传递些东东过去
                        if ($.isFunction(callback)) {
                            callback.call(null, null);
                        }
                        // $('#dg').datagrid('reload'); // reload the user data
                    } else {
                        $.messager.show({ // show error message
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    }
                }, 'json');
            },
            advanceSearch: function (formContent, dialogConfig, callback) {
                // 获取本方法的调用者函数对象
                var caller = pub.advanceSearch.caller ;
                formContent = caller['advSearchFormObj'] || formContent ;
                /*
                if (pub.advanceSearch.caller) {
                    var a = pub.advanceSearch.caller.toString();
                    alert(a);
                    caller['formContentCnt'] = caller['formContentCnt'] || 0 ;
                    caller['formContentCnt'] += 1 ;
                    alert(caller['formContentCnt']);
                }*/

                if ($.isFunction(dialogConfig)) {
                    callback = dialogConfig;
                    dialogConfig = {};
                }
                dialogConfig = dialogConfig || {};

                dialogConfig = $.extend({modal: true}, dialogConfig);

                // FIXME 简单的把iframe中的表单内容复制到这里还行不通 可能id冲突问题 用jquery封装表单对象的话 需要在关闭或者提交成功后把对象在"搬"回去
                // FIXME 最后使用了模版技巧
                if (typeof formContent == 'string') {
                    $('#adv_search_form').html(formContent);
                    //  $('#adv_search_form').html($("<div>"+formContent+"</div>").find('form').parent().html());
                } else {
                    $('#adv_search_form').empty().append(formContent);
                }

                $('#dlg_adv_search').dialog(dialogConfig).dialog('open');

                var formSelector = '#dlg_adv_search form';
                var $form = $(formSelector);
                // 隐藏原来的提交按钮
                $form.find(":submit").wrap("<div class='temp-wrap'></div>").css('display', 'none');
                // 让
                $form.off('submit').on('submit', function (e) {
                    // var $form = $(this);
                    // var formData = form.serialize();
                    var fields = $form.serializeArray();
                    console.log(fields);
                    var params = {};
                    $.each(fields, function (i, field) {
                        // 同时存在才保存！
                        if (field.name && field.value) {
                            params[field.name] = field.value
                        }
                    });
                    // console.log(params);
                    // 回调iframe中的方法
                    if ($.isFunction(callback)) {
                        // 原来iframe中的实现是： $('#dg').datagrid('load',params);
                        callback.call(null, params);
                    }

                    // 表单进行缓存 下次不用使用新的空表单了 具有“记忆”特征！
                    if(caller){
                        // 如果caller 不为null
                        // 如果函数是由顶层调用的，那么 caller 包含的就是 null
                        caller['advSearchFormObj'] = $('#adv_search_form').children();
                    }
                    // 关闭对话框
                    $('#dlg_adv_search').dialog('close');


                    // 阻止表单提交！
                    e.preventDefault();
                });

            },
            done: function (cb) {
                // 该方法在ajax调用结束后执行！
            }
        };

        /**
         * 创建与更新使用的是同一个逻辑！
         * */
        function createOrUpdate(url, dialogConfig, callback) {

            if ($.isFunction(dialogConfig)) {
                callback = dialogConfig;
                dialogConfig = {};
            }

            dialogConfig = dialogConfig || {};

            /*
             // 设置对话框配置：
             if(dialogConfig['style']){
             $("#dlg").css(dialogConfig['style']);
             }
             */
            dialogConfig = $.extend({modal: true}, dialogConfig);

            $('#ajax_form').html('稍等....');
            $('#dlg').dialog(dialogConfig).dialog('open');
            /*
             if($.isEmptyObject(dialogConfig)){
             $('#dlg').dialog('open');
             }else{
             $('#dlg').dialog(dialogConfig).dialog('open');
             }
             */

            $("#ajax_form").load(url, function () {

                var formSelector = '#ajax_form form';
                var $form = $(formSelector);
                // 重新渲染formSelector内的easyUi 元件 为他们应用css外观特效
                $.parser.parse(formSelector);

                onAjaxSubmitForm($form, callback);
                proxyAjaxFormSubmitButton($form);
            });
        }

        /**
         * 代理ajax表单中的提交按钮 隐藏它
         * */
        function proxyAjaxFormSubmitButton($form) {
            $form.find(":submit").wrap("<div class='temp-wrap'></div>").css('display', 'none');
            // $form.find(":submit").wrap("<div class='temp-wrap'></div>").parent('.temp-wrap').css('display', 'none');
        }

        /**
         * 提交ajax表单
         * */
        function doAdvSearch() {
            var formSelector = '#adv_search_form form';
            // 程序点击ajax表单中的提交按钮
            $(formSelector).find(":submit").click();
        }

        /**
         * 提交ajax表单
         * */
        function saveAjaxForm() {
            var formSelector = '#ajax_form form';
            // 程序点击ajax表单中的提交按钮
            $(formSelector).find(":submit").click();
        }


        function onAjaxSubmitForm($form, callback) {
            // get the form id and set the event handler
            $form.off('beforeSubmit').on('beforeSubmit', function (e) {
                ajaxSubmitForm($(this), callback);
                return false;
            })
                .on('submit', function (e) {
                    // 上面ajax提交逻辑也可以放这里 但存在 多次提交现象 一直找不出原因！ 估计是搜索表单跟ajax加载的表单id重复引起！
                    e.preventDefault();
                });
        }

        /**
         *
         * @param $form
         */
        function ajaxSubmitForm($form, callback) {
            // get the form id and set the event handler
            $.post(
                $form.attr("action"),
                $form.serialize()
            )
                .done(function (rsp) {
                    if (rsp.status == 'error') {
                        var formSelector = '#ajax_form form';
                        var $form = $(formSelector);
                        // $form.parent().html(rsp.data); // 这段代码执行后新表单就不是原先的表单了 所以改用下面的实现
                        // FIXME 估计低下的事件监听可以去掉 因为表单元素没变 只不过内部内容换掉了 原先注册的事件应该还在，
                        // FIXME 多次绑定同一个事件 可以考虑幂等性 （先注销所有事件然后在绑 不要上来就绑定监听函数可能会被执行多次的
                        // FIXME yii所有的js文件在幂等性这里做的比较好 可参看yii的几个js文件 activeForm...）
                        $form.html($(''+rsp.data+'').find('form').html());
                        // alert($form.size());
                        // 递归调用自己
                        onAjaxSubmitForm($form);
                        proxyAjaxFormSubmitButton($form,callback);
                        // 重新渲染formSelector内的easyUi 元件 为他们应用css外观特效
                        $.parser.parse(formSelector);

                    } else {
                        // 重新加载数据表格 如果必要可以传递些东东过去
                        if ($.isFunction(callback)) {
                            callback.call(null, null);
                        }
                        // 关闭对话框
                        $('#dlg').dialog('close');
                    }
                })
                .fail(function () {
                    console.log("server error");
                });
        }

        /**
         *
         * @param msg
         */
        function msgAlert(msg) {
            // 如果存在父窗体 那么调用父窗体的改方法
            var jq = parent ? parent.$ : $;
            jq.messager.alert('提示!', msg, 'info');

        }

        // 初始化
        pub.init();

        return pub;
    })();

    /**
     * 重置表单
     *
     * @param resetBtn
     */
    function clearForm(resetBtn){
        $(resetBtn).closest('form').form('clear');
    }

    function addTab(title, url) {
        if ($('#tt').tabs('exists', title)) {
            $('#tt').tabs('select', title);
        } else {
            // var content = '<iframe scrolling="auto" frameborder="0" src="'+url+'" style="width:100%;height:100%;"></iframe>';
            var content = '<iframe scrolling="auto" frameborder="0" src="' + url + '" style="width:100%;height:1154px;"></iframe>';
            $('#tt').tabs('add', {
                title: title,
                content: content,
                closable: true
            });
        }
    }
</script>
<?php \year\widgets\JsBlock::end() ?>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
