<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$idField = '' ;
if (count($pks) === 1) {
   $idField = $pks[0]; // fix for non-id columns
} else {
    $idField = implode(',', $pks);
}

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
    <script type="html/x-tamplate" id="adv_search_container">
<?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>

<?= "    <?php " . ($generator->indexWidgetType === 'grid' ? " " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
    </script>
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
       idField="<?= $idField ?>"
       pageSize="5"
       pageList="[5,10,20]"
       toolbar="#tb"
       data-options="
				singleSelect: true,
				iconCls: 'icon-save',
				url: '<?= "<?= Url::to(['grid-data']) ?>"  ?>',
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

    <?= '<?=' ?> Html::beginForm([ 'method' => 'get', ]) ?>
<!--  可用style布局输入框 ：   Html::activeTextInput($searchModel,'attribute',['style'=>'line-height:26px;border:1px solid #ccc' ]) ?>-->
    <?php
    $i = 0 ;
    foreach ($tableSchema->columns as $column):
     if($i == 3){
         echo " <?php /* ?> ";
     }
        ?>
    <span><?= '<?=' ?> $searchModel->getAttributeLabel('<?= $column->name ?>') ?>:</span>
    <?= '<?=' ?> Html::activeTextInput($searchModel,'<?= $column->name ?>',[]) ?>
        <?php
    $i++ ;
    endforeach ;
    if($i>=3){
        echo '<?php */ ?>';
    }
    ?>

    <a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch(this)">搜索</a>
    <?= '<?=' ?> Html::endForm() ?>

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

<?= '<?php ' ?> \year\widgets\JsBlock::begin() ?>
    <script>

        /**
         *
         */
        function append() {
            var url = '<?= "<?=" ?>  Url::to(['create']) ?>';
            parent.easyCrud.create(url,{title:"创建",width:450} , reloadDataGrid);
        }

        /**
         *
         */
        function edit() {
            var url = '<?= "<?=" ?>  Url::to(['update','id'=>'__id']) ?>';
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
            var url = '<?= "<?=" ?>   Url::to(['delete','id'=>'__id']) ?>';
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
         * 搜索
         * */
        function doSearch(searchButton){
            var $form = $(searchButton).closest('form');
            // var formData = form.serialize();
            var fields = $form.serializeArray();
            var params = {};
            $.each( fields, function(i, field){
                // 同时存在才保存！
                if(field.name && field.value){
                    params[field.name] = field.value
                }
            });
            $('#dg').datagrid('load',params);
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
<?= '<?php ' ?> \year\widgets\JsBlock::end()?>