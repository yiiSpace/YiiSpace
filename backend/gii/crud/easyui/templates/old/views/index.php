<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">


    <p>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Create {modelClass}',
            ['modelClass' => Inflector::camel2words(StringHelper::basename($generator->modelClass))]) ?>, ['create'], ['class' => 'easyui-linkbutton','data-options'=>"iconCls:'icon-create'"]) ?>
    </p>

<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>


<?php if ($generator->indexWidgetType === 'grid'): ?>
<!--    // 可以删掉这里的yii风格的gridView-->
    <?= "<?php  " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
            ['class' => 'yii\grid\SerialColumn'],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>

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
				url: '<?= "<?= Url::to(['grid-data']) ?>"  ?>',
				pagination:true,
				method: 'get',
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
       <?php

       foreach ($tableSchema->columns as $column) {
           $format = $generator->generateColumnFormat($column);

              // echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
              // echo "   <th data-options="field:'itemid',width:80">Item ID</th>        \n";
           /*
                        echo \yii\helpers\Html::tag('th',$column->name,[
                        /*
                            'data'=>[
                                'options'=>"field:\'{$column->name}\'"
                            ] ,

                            'data-options'=>"field:'{$column->name}'"
                         ]), " \n ";
                     */
           echo <<<TH
      <th data-options="field:'{$column->name}',width:80" sortable="true" >$column->name</th>
TH;
           echo "\n";

       }
       ?>

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
    <a href="javascript:void(0)" class="easyui-linkbutton"
       data-options="iconCls:'icon-save',plain:true" onclick="accept()">
        Accept
    </a>
    <a href="javascript:void(0)" class="easyui-linkbutton"
       data-options="iconCls:'icon-undo',plain:true" onclick="reject()">
        Reject
    </a>
    <a href="javascript:void(0)" class="easyui-linkbutton"
       data-options="iconCls:'icon-search',plain:true" onclick="getChanges()">
        GetChanges
    </a>
</div>


<div id="dlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
     closed="true" buttons="#dlg-buttons"
     data-options="
        onResize:function(){
            $(this).dialog('center');
        }"
    >
    <div id="ajax_form">稍等......</div>
</div>
<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6"
       iconCls="icon-ok" onclick="saveAjaxForm()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton"
       iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
</div>

<?= '<?php ' ?> \year\widgets\JsBlock::begin() ?>
    <script>
        /**
         *
         */
        function append()
        {
            var url = '<?= '<?= ' ?> Url::to(['create']) ?>';
            $("#ajax_form").load(url,function(){
                $('#dlg').dialog('open').dialog('setTitle','New User');
                // $('#fm').form('clear');
                var formSelector = '#ajax_form form' ;
                ajaxSubmitForm(formSelector);
                proxyAjaxFormSubmitButton(formSelector);
            });
        }
        /**
         * 代理ajax表单中的提交按钮 隐藏它
         * */
        function proxyAjaxFormSubmitButton(formSelector)
        {
             $(formSelector).find(":submit").wrap("<div class='temp-wrap'></div>").css('display','none');
        }
        /**
         * 提交ajax表单
         * */
        function saveAjaxForm(){
            var formSelector = '#ajax_form form' ;
            // 程序点击ajax表单中的提交按钮
            $(formSelector).find(":submit").click() ;

        }
        /**
         *
         */
        function edit()
        {
            var url = '<?= '<?= ' ?> Url::to(['update','id'=>'__id']) ?>';
            var row = $('#dg').datagrid('getSelected');
            if (row){
                // 替换变量占位符
                url = url.replace('__id',row.id);
                $("#ajax_form").load(url,function(){
                    $('#dlg').dialog('open').dialog('setTitle','Edit Record');
                    // $('#fm').form('clear');
                    var formSelector = '#ajax_form form' ;
                    ajaxSubmitForm(formSelector)
                    proxyAjaxFormSubmitButton(formSelector);
                });
            }else{
                $.messager.alert('提示!','请先选择一条记录!','info');
            }
        }

        function removeIt()
        {
            var url = '<?= '<?= ' ?> Url::to(['delete','id'=>'__id']) ?>';
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirm','Are you sure you want to destroy this user?',function(r){
                    // 替换变量占位符
                    url = url.replace('__id',row.id);
                    if (r){
                        $.post(url,{id:row.id},function(result){
                            if (result.success){
                                $.messager.alert('提示!','操作成功!','info');
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
                $.messager.alert('提示!','请先选择一条记录!','info');
            }
        }

        /**
         * 重新加载数据表格中的内容 注意与load方法的区别：reload 是刷新当前页 load是重新加载--又跑第一页去了
         */
        function reloadDataGrid(){
            $('#dg').datagrid('reload'); // reload the user data
        }
        function ajaxSubmitForm($formSelector) {
            // get the form id and set the event handler
            $($formSelector).on('beforeSubmit', function(e) {
                // TODO 这里 好像又可以了 见鬼了 ，  把下面onSubmit中的代码移上了就可以有js端验证能了了！
                // alert("beforeSubmit");
                // 竟然不执行
                return false;
            }).on('submit', function(e){
                var form = $(this);
                $.post(
                    form.attr("action"),
                    form.serialize()
                )
                    .done(function(result) {
                        if(result.error){
                            form.parent().html(result.data);
                            // 递归调用自己
                            ajaxSubmitForm($formSelector);
                            proxyAjaxFormSubmitButton($formSelector);

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

                e.preventDefault();
            });
        }

    </script>
<?= '<?php ' ?> \year\widgets\JsBlock::end()?>