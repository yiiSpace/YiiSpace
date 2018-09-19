<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">


    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'User',
]), ['create'], ['class' => 'easyui-linkbutton','data-options'=>"iconCls:'icon-create'"]) ?>
    </p>

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>


<!--    // 可以删掉这里的yii风格的gridView-->
    <?php  GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'auth_key',
            'password_hash',
            'password_reset_token',
            // 'email:email',
            // 'status',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<div style="margin:20px 0;"></div>
<!--data-options 出现的属性对 也可以作为tabl标签的属性出现！-->
<table id="dg" class="easyui-datagrid" title="DataGrid Row Style" style="width:100%;height:auto"
       idField="id"
       pageSize="5"
       pageList="[5,10,20]"
       toolbar="#tb"
       data-options="
				singleSelect: true,
				iconCls: 'icon-save',
				url: '<?= Url::to(['grid-data']) ?>',
				pagination:true,
				method: 'get',
              onLoadSuccess:onDataGridLoadSuccess,
				remoteSort:true,
				multiSort:true,
				rowStyler: function(index,row){
					if (row.listprice < 30){
						return 'background-color:#6293BB;color:#fff;font-weight:bold;';
					}
				}
			">
    <thead>
    <tr>
        <th field="ck" checkbox="true"></th>
             <th data-options="field:'id',width:80" sortable="true" >id</th>
      <th data-options="field:'username',width:80" sortable="true" >username</th>
      <th data-options="field:'auth_key',width:80" sortable="true" >auth_key</th>
      <th data-options="field:'password_hash',width:80" sortable="true" >password_hash</th>
      <th data-options="field:'password_reset_token',width:80" sortable="true" >password_reset_token</th>
      <th data-options="field:'email',width:80" sortable="true" >email</th>
      <th data-options="field:'status',width:80" sortable="true" >status</th>
      <th data-options="field:'created_at',width:80" sortable="true" >created_at</th>
      <th data-options="field:'updated_at',width:80" sortable="true" >updated_at</th>

    </tr>
    </thead>
</table>

<div id="tb" style="height:auto">
    <a href="javascript:void(0)" class="easyui-linkbutton"
       data-options="iconCls:'icon-add',plain:true" onclick="append()">
        Append
    </a>
    <a href="javascript:void(0)" class="easyui-linkbutton"
       data-options="iconCls:'icon-edit',plain:true" onclick="edit()">
        edit
    </a>
    <a href="javascript:void(0)" class="easyui-linkbutton"
       data-options="iconCls:'icon-remove',plain:true" onclick="removeIt()">
        Remove
    </a>
<!--
    这部分用的是 EDataGrid  功能 才需要的按钮
    <a href="javascript:void(0)" class="easyui-linkbutton"
       data-options="iconCls:'icon-save',plain:true" onclick="accept()">
        Accept
    </a>
    <a href="javascript:void(0)" class="easyui-linkbutton"
       data-options="iconCls:'icon-undo',plain:true" onclick="reject()">
        Reject
    </a>
 -->

    <a href="javascript:void(0)" class="easyui-linkbutton"
       data-options="iconCls:'icon-search',plain:true" onclick="getChanges()">
        GetChanges
    </a>
    <a href="#" class="easyui-menubutton" menu="#mm_export" iconCls="icon-export">导出</a>
</div>
<div id="mm_export" style="width:100px;">
    <div>
        <a id="exportCurrentPage" href="" onclick="formPost($(this).attr('href'),{p1:1,p2:2}); return false ;">当前页</a>
    </div>
    <div>全部</div>
</div>


<?php  \year\widgets\JsBlock::begin() ?>
    <script>

        /**
         *
         */
        function append()
        {
            var url = '<?=  Url::to(['create']) ?>';
            $("#ajax_form").load(url,function(){
                var jq = parent ? parent.$ : $ ;

                jq('#dlg').dialog('open').dialog('setTitle','New User');
                // $('#fm').form('clear');
                // $('#fm').form('clear');
                var formSelector = '#ajax_form form' ;
                var $form = jq(formSelector) ;
                onAjaxSubmitForm($form);
                proxyAjaxFormSubmitButton($form);
            });
        }
        /**
         * 代理ajax表单中的提交按钮 隐藏它
         * */
        function proxyAjaxFormSubmitButton($form)
        {
             // $(formSelector).find(":submit").wrap("<div class='temp-wrap'></div>").css('display','none');
            $form.find(":submit").wrap("<div class='temp-wrap'></div>").parent('.temp-wrap').css('display','none');
        }
        /**
         * 提交ajax表单
         * */
        function saveAjaxForm(){
            var formSelector = '#ajax_form form' ;
            // 程序点击ajax表单中的提交按钮
            var jq = parent ? parent.$ : $ ;
alert("yaaa");
            $(formSelector).find(":submit").click() ;
            // ajaxSubmitForm($(formSelector));
            //  $(formSelector).yiiActiveForm('validate');
            // alert("yaaa");
            // $(formSelector).trigger('beforeSubmit');
            //alert('trigger submit');
            // $(formSelector).trigger('submit');
            // $($(formSelector).attr('id')).yiiActiveForm('submitForm');
        }
        /**
         *
         */
        function edit()
        {
            var url = '<?=  Url::to(['update','id'=>'__id']) ?>';
            var row = $('#dg').datagrid('getSelected');
            if (row){
                // 替换变量占位符
                url = url.replace('__id',row.id);

                var jq = parent ? parent.$ : $ ;
                jq('#dlg').dialog('open').dialog('setTitle','Edit Record');

                // 注册确定按钮的回调事件:
                jq("#save_ajax_form").off('click').on('click',function(){
                    alert("hi");
                    saveAjaxForm();
                });

                jq("#ajax_form").load(url,function(){
                    // jq('#dlg').dialog('open').dialog('setTitle','Edit Record');
                      /*
                    var formSelector = '#ajax_form form' ;
                    var $form = jq(formSelector) ;
                    onAjaxSubmitForm($form);
                    proxyAjaxFormSubmitButton($form);
                    */
                });
            }else{
                msgAlert('请先选择一条记录!');
            }
        }

        function removeIt()
        {
            var url = '<?=  Url::to(['delete','id'=>'__id']) ?>';
            var row = $('#dg').datagrid('getSelected');
            if (row){
                var jq = parent ? parent.$ : $ ;

                jq.messager.confirm('Confirm','Are you sure you want to destroy this user?',function(r){
                    // 替换变量占位符
                    url = url.replace('__id',row.id);
                    if (r){
                        $.post(url,{id:row.id},function(rsp){
                            if (rsp.status == 'success'){
                                msgAlert(rsp.msg);
                                $('#dg').datagrid('reload'); // reload the user data
                            } else {
                                $.messager.show({ // show error message
                                    title: 'Error',
                                    msg: result.errorMsg
                                });
                            }
                        },'json');
                    }
                });
            }else{
                msgAlert('请先选择一条记录!');
            }
        }

        /**
         * 重新加载数据表格中的内容 注意与load方法的区别：reload 是刷新当前页 load是重新加载--又跑第一页去了
         */
        function reloadDataGrid(){
            $('#dg').datagrid('reload'); // reload the user data
        }
        function onAjaxSubmitForm($form){
            // get the form id and set the event handler
            $form.on('beforeSubmit', function(e) {
                alert("hiii");
                ajaxSubmitForm($(this));
                return false;
            })
            .on('submit', function(e){
                // 上面ajax提交逻辑也可以放这里 但存在 多次提交现象 一直找不出原因！ 估计是搜索表单跟ajax加载的表单id重复引起！
                e.preventDefault();
            });
    }
        /**
         *
         * @param $form
         */
        function ajaxSubmitForm($form) {
            alert("www");
            // get the form id and set the event handler
            $.post(
                $form.attr("action"),
                $form.serialize()
            )
            .done(function(rsp) {
                if(rsp.status == 'error'){
                    $form.parent().html(result.data);
                    // 递归调用自己
                    onAjaxSubmitForm($form);
                    proxyAjaxFormSubmitButton($form);
                }else{
                    // alert("close the dialog");
                    $.messager.show({ // show error message
                        title: 'success',
                        msg: '保存成功！'
                    });
                    // 重新加载数据表格
                    reloadDataGrid();
                    // 关闭对话框
                    $('#dlg').dialog('close');
                }
                // window.ajaxDialog.close().remove();
            })
            .fail(function() {
                console.log("server error");
            });
        }
        /**
         *
         * @param msg
         */
        function msgAlert(msg){
            // 如果存在父窗体 那么调用父窗体的改方法
            if(parent){
                parent.$.messager.alert('提示!',msg,'info');
            }else{
                $.messager.alert('提示!',msg,'info');
            }

        }

        /**
         * 主要是记录本次请求的url 可用来做数据导出用
         *
         * @param data
         */
        function onDataGridLoadSuccess(data){
            // console.log(data);
            if(data.url){
               // console.log(data.url);
                // 设定到导出当前页的链接上
                $("#exportCurrentPage").attr("href",data.url);
            }
        }
    </script>
<?php  \year\widgets\JsBlock::end()?>