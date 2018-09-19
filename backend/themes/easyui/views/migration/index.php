<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MigrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Migrations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="migration-index">


    <p>
        <?= Html::a('Create Migration', ['create'], ['class' => 'easyui-linkbutton','data-options'=>"iconCls:'icon-create'"]) ?>
    </p>

    <script type="html/x-tamplate" id="adv_search_container">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    </script>



<!--    // 可以删掉这里的yii风格的gridView-->
    <?php  GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'version',
            'apply_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<div style="margin:20px 0;"></div>
<!--data-options 出现的属性对 也可以作为tabl标签的属性出现！-->
<table id="dg" class="easyui-datagrid" title="DataGrid Row Style" style="width:100%;height:auto"

       pageSize="5"
       pageList="[5,10,20]"
       toolbar="#tb"
       data-options="
				singleSelect: true,
				iconCls: 'icon-save',
				idField:'version',
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
             <th data-options="field:'version',width:80" sortable="true" >version</th>
      <th data-options="field:'apply_time',width:80" sortable="true" >apply_time</th>

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
    <a href="#" class="easyui-menubutton" menu="#mm_export" iconCls="icon-export">导出为Excel</a>
    <a href="javascript:void(0)" class="easyui-linkbutton"
       data-options="iconCls:'icon-search',plain:true" onclick="advSearch()">
        高级搜索
    </a>
</div>
<!--下拉菜单-->
<div id="mm_export" style="width:100px;">
    <div>
        <a id="exportCurrentPage" href="" class="export-grid-action"
           onclick="formPost($(this).attr('href'),{exportMode:'paging'}); return false ;">
            当前页
        </a>

    </div>
    <div>
        <a id="exportFull" href="" class="export-grid-action"
           onclick="formPost($(this).attr('href'),{exportMode:'full'}); return false ;">
            全部
        </a>
    </div>
</div>

<?php  \year\widgets\JsBlock::begin() ?>
    <script>

        /**
         *
         */
        function append() {
            var url = '<?=  Url::to(['create']) ?>';
            parent.easyCrud.create(url,{title:"创建",width:450} , reloadDataGrid);
        }

        /**
         *
         */
        function edit() {
            var url = '<?=  Url::to(['update','id'=>'__id']) ?>';
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                // 替换变量占位符
                url = url.replace('__id', row.id);
                // 调用父对象的update方法
                parent.easyCrud.update(url,{title:"修改",width:450} , reloadDataGrid);

            } else {
                msgAlert('请先选择一条记录!');
            }
        }

        function removeIt() {
            var url = '<?=   Url::to(['delete','id'=>'__id']) ?>';
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                var jq = parent ? parent.$ : $;
                jq.messager.confirm('Confirm', 'Are you sure you want to destroy this user?', function (r) {
                    // 替换变量占位符
                    url = url.replace('__id', row.id);
                    if (r) {
                        parent.easyCrud.del(url,{id:row.id} ,reloadDataGrid);
                    }
                });
            } else {
                msgAlert('请先选择一条记录!');
            }
        }

        /**
         * 高级搜索功能
         *
         * */
        function advSearch(){
            var advSearchFormContent = $("#adv_search_container").html();
            // alert(advSearchFormContent);
            // var advSearchFormContent = $("#adv_search_container form").clone();

            parent.easyCrud.advanceSearch(advSearchFormContent,{title:"高级搜索",width:450} , function(params){
                console.log(params);
                $('#dg').datagrid('load',params);
            });

        }

        /**
         * 重新加载数据表格中的内容 注意与load方法的区别：reload 是刷新当前页 load是重新加载--又跑第一页去了
         */
        function reloadDataGrid(){
            $('#dg').datagrid('reload'); // reload the user data
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
                $("a.export-grid-action").attr("href", data.url);
            }
        }
    </script>
<?php  \year\widgets\JsBlock::end()?>