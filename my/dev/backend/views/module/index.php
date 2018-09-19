<?php
/* @var $this yii\web\View */
/* @var $modules yii\base\Module[] */

use yii\helpers\Html ;
?>
<h1>module/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>

<?php \year\widgets\CssBlock::begin()?>
<style>
.modules li{
    border: dashed darkkhaki 2px;
    margin: 5px;
    padding: 15px;
    list-style: none;
}
</style>
<?php \year\widgets\CssBlock::end()?>

<ul class="modules" data-api-endpoint="<?= \yii\helpers\Url::to(['tables4module']) ?>">
    <?php foreach ($modules as $moduleId => $module) : ?>
        <li class="module" data-module="<?= $moduleId ?>" >
            <? print_r($moduleId) ?>
            <br/>
            <?php
             try{
                 // 强制加载
                 $module = Yii::$app->getModule($moduleId) ;
             }catch(\Exception $ex){
                 continue ;
             }

            // ?>
            地址
            <?= $module->basePath ?> <br/>
            dirname
            <?= dirname($module->basePath) ?> <br/>
            <?php // $module->controllerPath ?>
            <br/>
            模型地址:
            <?php var_dump($modelsPaths[$moduleId]) ?>

            <br/>
            giiant 命令
            <?php
             // \yii\helpers\VarDumper::dump($giiCommands[$moduleId]) ;
             var_dump($giiCommands[$moduleId]) ;
            ?>
            <p>
                tables:
                <?= Html::submitButton('加载本模块负责的表', ['class' =>  ' btn btn-primary btn-mini act-tables-of-module ']) ?>
                <div class="panel tables-of-module" >

                </div>
            </p>
        </li>
    <?php endforeach ?>

</ul>

<?php

\yii\bootstrap\Modal::begin([
    'header' => '<h4>Destination</h4>',
    'id'     => 'model4table',
    'size'   => 'model-lg',
]);

echo "<div id='modelContent'></div>";

\yii\bootstrap\Modal::end();
?>

<?php \year\widgets\JsBlock::begin()?>
<script>
   $(function(){
       $('.act-tables-of-module').on('click',function(e){
            var $moduleContainer = $(this).closest('.module');
            var moduleId = $moduleContainer.data('module');
            // alert(moduleId);
           var apiEndpoint = $moduleContainer.parent('.modules').data('api-endpoint') ;

           var $tables =  $moduleContainer.find('.tables-of-module') ;
           // alert(apiEndpoint) ;
           $.post(apiEndpoint,
               {moduleId : moduleId},
               function(resp){
                    $tables.empty();
                   // alert(resp) ;
                   $.each(resp,function(idx,item){
                       var $item = $('<div></div>');
                       $item.addClass('module-table').data('table',item).html(item);
                       // items +=  $item.wrap("<div class='wrap'></div>").parent().html();
                       // items +=  '<div class="module-table">'+ item + '</div>' ;
                       $tables.append($item) ;
                   });
                   if($tables.html() == ''){
                       items  = '本模块暂时还没有相关的表！';
                       $tables.html(items);
                   }

               }
           );
       });
   }) ;

   function getMigration4tableUrl(table){
       var url = '<?= \yii\helpers\Url::to(['/dev/shell/migration','table'=>'_table']) ?>';
        return url.replace('_table',table);
   }
   $(function(){
       $(document).on('click','.module-table',function(e){
           var table = $(this).data('table');
           $('#model4table').modal('show')
               .find('#modelContent')
                .html('...') 
               .load(getMigration4tableUrl(table)) ;
               // .load($(this).attr('value'));
       });
   });
</script>
<?php \year\widgets\JsBlock::end()?>