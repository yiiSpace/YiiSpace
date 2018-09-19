<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdminMenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Admin Menus');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-menu-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Admin Menu',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'root',
            'lft',
            'rgt',
            'lvl',
            // 'name',
            // 'url:url',
            // 'icon',
            // 'icon_type',
            // 'active',
            // 'selected',
            // 'disabled',
            // 'readonly',
            // 'visible',
            // 'collapsed',
            // 'movable_u',
            // 'movable_d',
            // 'movable_l',
            // 'movable_r',
            // 'removable',
            // 'removable_all',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<div style="margin:20px 0;"></div>
<!--data-options 出现的属性对 也可以作为tabl标签的属性出现！-->
<table class="easyui-datagrid" title="DataGrid Row Style" style="width:700px;height:250px"
       pageSize="5"
       pageList="[5,10,20]"
       toolbar="#tb"
       data-options="
				singleSelect: true,
				iconCls: 'icon-save',
				url: '<?= Url::to(['grid-data']) ?>',
				pagination:true,
				method: 'get',
				rowStyler: function(index,row){
					if (row.listprice < 30){
						return 'background-color:#6293BB;color:#fff;font-weight:bold;';
					}
				}
			">
    <thead>
    <tr>
             <th data-options="field:'id',width:80">id</th>
      <th data-options="field:'root',width:80">root</th>
      <th data-options="field:'lft',width:80">lft</th>
      <th data-options="field:'rgt',width:80">rgt</th>
      <th data-options="field:'lvl',width:80">lvl</th>
      <th data-options="field:'name',width:80">name</th>
      <th data-options="field:'url',width:80">url</th>
      <th data-options="field:'icon',width:80">icon</th>
      <th data-options="field:'icon_type',width:80">icon_type</th>
      <th data-options="field:'active',width:80">active</th>
      <th data-options="field:'selected',width:80">selected</th>
      <th data-options="field:'disabled',width:80">disabled</th>
      <th data-options="field:'readonly',width:80">readonly</th>
      <th data-options="field:'visible',width:80">visible</th>
      <th data-options="field:'collapsed',width:80">collapsed</th>
      <th data-options="field:'movable_u',width:80">movable_u</th>
      <th data-options="field:'movable_d',width:80">movable_d</th>
      <th data-options="field:'movable_l',width:80">movable_l</th>
      <th data-options="field:'movable_r',width:80">movable_r</th>
      <th data-options="field:'removable',width:80">removable</th>
      <th data-options="field:'removable_all',width:80">removable_all</th>

    </tr>
    </thead>
</table>

<div id="tb" style="height:auto">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="edit()">Edit</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeIt()">Remove</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="accept()">Accept</a>
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
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
</div>

<?php \year\widgets\JsBlock::begin() ?>
<script>
    function append()
    {
        var url = '<?php echo Url::to(['create']) ?>';
        $("#ajax_form").load(url,function(){
            $('#dlg').dialog('open').dialog('setTitle','New User');
            // $('#fm').form('clear');
            ajaxSubmitForm('#ajax_form form')
        });
    }

    function removeIt()
    {

    }

    function ajaxSubmitForm($formSelector) {
        // get the form id and set the event handler
        $($formSelector).on('beforeSubmit', function(e) {
            alert("beforeSubmit");
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
                   }else{
                       alert("close the dialog");
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
<?php \year\widgets\JsBlock::end()?>