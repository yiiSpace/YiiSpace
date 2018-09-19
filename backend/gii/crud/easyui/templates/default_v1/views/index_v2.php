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

$modelId = Inflector::camel2id(StringHelper::basename($generator->modelClass)) ;

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
<div class="<?= $modelId ?>-index">


    <p>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Create {modelClass}',
            ['modelClass' => Inflector::camel2words(StringHelper::basename($generator->modelClass))]) ?>, ['create'], ['class' => 'easyui-linkbutton','data-options'=>"iconCls:'icon-create'"]) ?>
    </p>

<?php if(!empty($generator->searchModelClass)): ?>
    <script type="html/x-tamplate" id="adv_search_container_<?= $modelId ?>">
<?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>

<?= "    <?php " . ($generator->indexWidgetType === 'grid' ? " " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
    </script>
<?php endif; ?>


<?php if ($generator->indexWidgetType === 'grid'): ?>
<!--    // 可以删掉这里的yii风格的gridView-->
    <?= "<?php  " ?>GridView::widget([
        'id'=>'grid_<?= $modelId ?>',
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
        'id' => 'list_<?= $modelId ?>',
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
<table id="dg_<?= $modelId ?>" class="easyui-datagrid" title="DataGrid Row Style" style="width:100%;height:auto"
       idField="<?= $idField ?>"
       pageSize="5"
       pageList="[5,10,20]"
       toolbar="#tb_<?= $modelId ?>"
       data-options="
				singleSelect: true,
				iconCls: 'icon-save',
				url: '<?= "<?= Url::to(['grid-data']) ?>"  ?>',
				pagination:true,
				method: 'get',
              onLoadSuccess:<?= $modelId ?>Admin.onDataGridLoadSuccess,
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

<div id="tb_<?= $modelId ?>" style="height:auto">

    <?= '<?=' ?> Html::beginForm([ 'method' => 'get', ]) ?>

    <a href="javascript:void(0)" class="easyui-linkbutton"
       data-options="iconCls:'icon-add',plain:true" onclick="<?= $modelId ?>Admin.append()">
        Append
    </a>
    <a href="javascript:void(0)" class="easyui-linkbutton"
       data-options="iconCls:'icon-edit',plain:true" onclick="<?= $modelId ?>Admin.edit()">
        edit
    </a>
    <a href="javascript:void(0)" class="easyui-linkbutton"
       data-options="iconCls:'icon-remove',plain:true" onclick="<?= $modelId ?>Admin.remove()">
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

    <a href="javascript:void(0);" class="easyui-menubutton" menu="#mm_export_<?= $modelId ?>" iconCls="icon-export">导出为Excel</a>


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

    <a href="#" class="easyui-linkbutton" plain="true" onclick="<?= $modelId ?>Admin.doSearch(this)">搜索</a>


    <a href="javascript:void(0)" class="easyui-linkbutton"
       data-options="iconCls:'icon-search',plain:true" onclick="<?= $modelId ?>Admin.advSearch()">
        高级搜索
    </a>

    <?= '<?=' ?> Html::endForm() ?>

</div>
<!--下拉菜单-->
<div id="mm_export_<?= $modelId ?>" style="width:100px;">
    <div>
        <a id="<?= $modelId ?>ExportCurrentPage" href="" class="export-grid-action"
           onclick="formPost($(this).attr('href'),{exportMode:'paging'}); return false ;">
            当前页
        </a>

    </div>
    <div>
        <a id="<?= $modelId ?>ExportFull" href="" class="export-grid-action"
           onclick="formPost($(this).attr('href'),{exportMode:'full'}); return false ;">
            全部
        </a>
    </div>
</div>

<?= '<?php ' ?> \year\widgets\JsBlock::begin() ?>
    <script>
        /**
         * 每个实体对应一个相应的管理名空间 防止相互冲突！
         * */
        var <?= $modelId ?>Admin =  (function(){
               var pub = {

                    dataGridSelector:'#dg_<?= $modelId ?>', // 数据表格的jquery选择器
                        reloadDataGrid :function(){
                    /**
                     * 重新加载数据表格中的内容 注意与load方法的区别：reload 是刷新当前页 load是重新加载--又跑第一页去了
                     */
                    $(this.dataGridSelector).datagrid('reload'); // reload the grid data
                },

                    // 增
                    appendUrl:'<?= "<?=" ?>  Url::to(['create']) ?>',
                    append:function(){
                    var url = this.appendUrl;
                    top.easyCrud.create( url,{title:"创建",width:450} , this.reloadDataGrid );
                },

                    // 改
                    getEditUrl:function(row){
                        // 如有必要 做出修正
                        var url = '<?= "<?=" ?>  Url::to(['update','id'=>'__id']) ?>';
                        // 替换变量占位符
                        return   url.replace('__id', row.id);
                    },
                    edit:function(){
                        var row = $(this.dataGridSelector).datagrid('getSelected');
                        if (row) {
                            var url = this.getEditUrl(row);
                            // 调用父对象的update方法
                            top.easyCrud.update(url,{title:"修改",width:450} , this.reloadDataGrid);

                        } else {
                            msgAlert('请先选择一条记录!');
                        }
                    },

                    // 删
                    getDeleteUrl:function(row){
                        var url = '<?= "<?=" ?>   Url::to(['delete','id'=>'__id']) ?>';
                        // 替换变量占位符
                        return  url.replace('__id', row.id);

                    },
                    remove:function(){
                        var row = $(this.dataGridSelector).datagrid('getSelected');
                        if (row) {
                            var jq = parent ? parent.$ : $;
                            jq.messager.confirm('Confirm', ' 您确定要删除此项数据 ?', function (r) {
                                var url = this.getDeleteUrl(row) ;
                                if (r) {
                                    top.easyCrud.del(url,{id:row.id} ,this.reloadDataGrid);
                                }
                            });
                        } else {
                            msgAlert('请先选择一条记录!');
                        }
                    },

                    // 搜索
                    doSearch:function(searchButton){
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
                        $(this.dataGridSelector).datagrid('load',params);
                    },
                    // 高级搜索
                    advSearchContainerSelector : '#adv_search_container_<?= $modelId ?>',
                        advSearch : function(){
                    var advSearchFormContent = $(this.advSearchContainerSelector).html();
                    // var advSearchFormContent = $(advSearchFormContent+' form').clone();

                    // 声明变量 供下面的回调函数使用
                    var dataGridSelector = this.dataGridSelector ;

                    top.easyCrud.advanceSearch(advSearchFormContent,{title:"高级搜索",width:450} , function(params){
                        console.log(params);
                        $(dataGridSelector).datagrid('load',params);
                    });
                },

                    /**
                     * 主要是记录本次请求的url 可用来做数据导出用
                     *
                     * @param data
                     */
                    onDataGridLoadSuccess : function(data){
                        // console.log(data);
                        if(data.url){
                            // console.log(data.url);
                            // 导出动作选择符 如果必要 可以作为对象变量被传递
                            var exportGridActionContextSelector = '#mm_export_<?= $modelId ?>';
                            // 设定到导出当前页的链接上
                            $(exportGridActionContextSelector).find("a.export-grid-action").attr("href", data.url);
                        }
                    }

                };
                return pub ;
            })();



        // 对象初始化：
        <?= $modelId ?>Admin.dataGridSelector = '#dg_<?= $modelId ?>';
        <?= $modelId ?>Admin.appendUrl = '<?= "<?=" ?>  Url::to(['create']) ?>';
        <?= $modelId ?>Admin.dataGridSelector.advSearchContainerSelector = '#adv_search_container_<?= $modelId ?>';


        /**
         *
         * @param msg
         */
        function msgAlert(msg) {
            // 如果存在父窗体 那么调用父窗体的改方法
            var jq = parent ? parent.$ : $;
            jq.messager.alert('提示!', msg, 'info');

        }

    </script>
<?= '<?php ' ?> \year\widgets\JsBlock::end()?>