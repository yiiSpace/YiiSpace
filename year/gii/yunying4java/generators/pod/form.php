<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\module\Generator */

?>
<div class="module-form">


<?php
    
    echo $form->field($generator, 'podsPath');


 echo \yii\helpers\Html::a('选择路径 ', '#', [
     'id' => 'create',
     'data-toggle' => 'modal',
     'data-target' => '#fs-modal',
     'class' => 'btn btn-success',
 ]);

 echo $form->field($generator, 'podID',[]);

 \yii\bootstrap\Modal::begin([
     'id' => 'fs-modal',
     'header' => '<h4 class="modal-title">目录选择</h4>',
     'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
 ]);
 /*
 $requestUrl = Url::toRoute('create');
 $js = <<<JS
    $.get('{$requestUrl}', {},
        function (data) {
            $('.modal-body').html(data);
        }  
    );
JS;
 */
 // $this->registerJs($js);
 ?>
 <div id="modal_container">

 </div>
<?php
 \yii\bootstrap\Modal::end();
?>
</div>




<?php \year\widgets\JsTreeAsset::register($this) ?>
<?php  \year\widgets\JsBlock::begin() ?>
<script>
    $(function () {
        function getDiskRoot() {
            return  $(".disk-root").find("option:selected").text();
        }
        function  getRealPathUrl(id) {
            var url = '<?= \yii\helpers\Url::to(['//file-tree/fs','operation'=>'get_path','diskRoot'=>'_diskRoot_','id'=>'_id_']) ?>';
            url = url.replace('_diskRoot_',getDiskRoot());
            url = url.replace('_id_',id);
            return url ;
        }

        $(document).on('change','.disk-root' , function (e) {
            // alert($('.disk-root').find("option:selected").text() ) ;
            // @see https://www.cnblogs.com/swjian/p/6856706.html
            var v =    $(".disk-root").find("option:selected").text();
           // alert(v) ;
            // 重新加载 树
            // $('#jstree').jstree(true).settings.core.data = 'put/the/url/here.json';
            // $('#jstree').jstree(true).refresh();
            $('#tree').jstree(true).refresh();
        });

        $(window).resize(function () {
            var h = Math.max($(window).height() - 0, 420);
            $('#container, #data, #tree, #data .content').height(h).filter('.default').css('lineHeight', h + 'px');
        }).resize();

        $('#tree')
            .jstree({
                'core' : {
                    'data' : {
                        'url' : '<?= \yii\helpers\Url::to(['//file-tree/fs','operation'=>'get_node']) ?>',
                        'data' : function (node) {
                            var diskRoot =     $(".disk-root").find("option:selected").text();
                           // return { 'id' : node.id  };
                            return { 'id' : node.id  , diskRoot:diskRoot};
                        }
                    },
                    'check_callback' : function(o, n, p, i, m) {
                        if(m && m.dnd && m.pos !== 'i') { return false; }
                        if(o === "move_node" || o === "copy_node") {
                            if(this.get_node(n).parent === this.get_node(p).id) { return false; }
                        }
                        return true;
                    },
                    'force_text' : true,
                    'themes' : {
                        'responsive' : false,
                        'variant' : 'small',
                        'stripes' : true
                    }
                },
                'sort' : function(a, b) {
                    return this.get_type(a) === this.get_type(b) ? (this.get_text(a) > this.get_text(b) ? 1 : -1) : (this.get_type(a) >= this.get_type(b) ? 1 : -1);
                },

                'types' : {
                    'default' : { 'icon' : 'folder' },
                    'file' : { 'valid_children' : [], 'icon' : 'file' }
                },
                'unique' : {
                    'duplicate' : function (name, counter) {
                        return name + ' ' + counter;
                    }
                },
                'plugins' : ['state','dnd','sort','types','contextmenu','unique']
            })
            .on('changed.jstree', function (e, data) {
                if(data && data.selected && data.selected.length) {
                    var fileId = (data.selected[0]) ;
                     // console.log(data) ;
                     var url =  (getRealPathUrl(fileId));
                     $.get(url , function (data) {
                         $("input[name*='podsPath']").val(data) ;
                         alert('路径选择成功:'+data) ;
                    });
                }
                else {
                   // $('#data .content').hide();
                  //  $('#data .default').html('Select a file from the tree.').show();
                }
            });
    });
</script>
<?php  \year\widgets\JsBlock::end() ?>

<?php \year\widgets\PageletBlock::begin([
        'targetId'=>'modal_container',
]) ?>
<div id="file_browser" role="main">
    <?php

    $getFileRoots = function (){

        $roots = [] ;
        /** @var bool $isWindows */
        $isWindows = strtoupper(substr(PHP_OS,0,3))==='WIN'? true:false;

        if($isWindows){
            exec("wmic LOGICALDISK get name",$dir);
            $dir =  array_filter($dir) ; // 去除空值
            array_shift($dir) ;
            // print_r($dir) ;
            $roots = $dir ;
        }else{
            // linux platform
            $roots[] = '/' ;
            
        }

        return $roots ;
    } ;
    $fileRoots = $getFileRoots() ;
    array_unshift($fileRoots,'/') ;
    echo \yii\helpers\Html::dropDownList('disk_root',null, $fileRoots ,[  'class'=>'disk-root' ]) ;

    ?>

    <div id="tree" style="overflow: scroll"></div>

</div>
<?php \year\widgets\PageletBlock::end() ?>



