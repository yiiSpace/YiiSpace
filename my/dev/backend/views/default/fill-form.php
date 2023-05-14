<?php
/* @var $this yii\web\View */
/* @var $modules yii\base\Module[] */

use yii\helpers\Html ;

\common\widgets\FormDataJsonAsset::register($this) ;
?>
    <h1>module/index</h1>

    <p>
        You may change the content of this page by modifying
        the file <code><?= __FILE__; ?></code>.
    </p>

    <form action="" id="my_form">
        <input type="text" name="name"/>
        <button onclick="fillForm();return false ;">填充数据</button>
    </form>

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

    function fillForm(){
    alert('fill-form');
     FormDataJson.fromJson(document.querySelector("#my_form"), {'name': 'BrainFooLong'}, { clearOthers: true }) ;
 alert('fill-form-end');

    }


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