<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\module\Generator */

?>
<div class="module-form">

 <?php echo getenv("GOPATH") ?>

<?php
    
    echo $form->field($generator, 'podsPath');


 echo \yii\helpers\Html::a('选择 ', '#', [
     'id' => 'create',
     'data-toggle' => 'modal',
     'data-target' => '#fs-modal',
     'class' => 'btn btn-success',
 ]);

 echo $form->field($generator, 'podID');

 \yii\bootstrap\Modal::begin([
     'id' => 'fs-modal',
     'header' => '<h4 class="modal-title">创建</h4>',
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
                'contextmenu' : {
                    'items' : function(node) {
                        var tmp = $.jstree.defaults.contextmenu.items();
                        delete tmp.create.action;
                        tmp.create.label = "New";
                        tmp.create.submenu = {
                            "create_folder" : {
                                "separator_after"	: true,
                                "label"				: "Folder",
                                "action"			: function (data) {
                                    var inst = $.jstree.reference(data.reference),
                                        obj = inst.get_node(data.reference);
                                    inst.create_node(obj, { type : "default" }, "last", function (new_node) {
                                        setTimeout(function () { inst.edit(new_node); },0);
                                    });
                                }
                            },
                            "create_file" : {
                                "label"				: "File",
                                "action"			: function (data) {
                                    var inst = $.jstree.reference(data.reference),
                                        obj = inst.get_node(data.reference);
                                    inst.create_node(obj, { type : "file" }, "last", function (new_node) {
                                        setTimeout(function () { inst.edit(new_node); },0);
                                    });
                                }
                            }
                        };
                        if(this.get_type(node) === "file") {
                            delete tmp.create;
                        }
                        return tmp;
                    }
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
            .on('delete_node.jstree', function (e, data) {
                $.get('?operation=delete_node', { 'id' : data.node.id })
                    .fail(function () {
                        data.instance.refresh();
                    });
            })
            .on('create_node.jstree', function (e, data) {
                $.get('?operation=create_node', { 'type' : data.node.type, 'id' : data.node.parent, 'text' : data.node.text })
                    .done(function (d) {
                        data.instance.set_id(data.node, d.id);
                    })
                    .fail(function () {
                        data.instance.refresh();
                    });
            })
            .on('rename_node.jstree', function (e, data) {
                $.get('?operation=rename_node', { 'id' : data.node.id, 'text' : data.text })
                    .done(function (d) {
                        data.instance.set_id(data.node, d.id);
                    })
                    .fail(function () {
                        data.instance.refresh();
                    });
            })
            .on('move_node.jstree', function (e, data) {
                $.get('?operation=move_node', { 'id' : data.node.id, 'parent' : data.parent })
                    .done(function (d) {
                        //data.instance.load_node(data.parent);
                        data.instance.refresh();
                    })
                    .fail(function () {
                        data.instance.refresh();
                    });
            })
            .on('copy_node.jstree', function (e, data) {
                $.get('?operation=copy_node', { 'id' : data.original.id, 'parent' : data.parent })
                    .done(function (d) {
                        //data.instance.load_node(data.parent);
                        data.instance.refresh();
                    })
                    .fail(function () {
                        data.instance.refresh();
                    });
            })
            .on('changed.jstree', function (e, data) {
                if(data && data.selected && data.selected.length) {
                    alert(data.selected[0]) ;
                    console.log(data) ;
                    $.get('?operation=get_content&id=' + data.selected.join(':'), function (d) {
                        if(d && typeof d.type !== 'undefined') {
                            $('#data .content').hide();
                            switch(d.type) {
                                case 'text':
                                case 'txt':
                                case 'md':
                                case 'htaccess':
                                case 'log':
                                case 'sql':
                                case 'php':
                                case 'js':
                                case 'json':
                                case 'css':
                                case 'html':
                                    $('#data .code').show();
                                    $('#code').val(d.content);
                                    break;
                                case 'png':
                                case 'jpg':
                                case 'jpeg':
                                case 'bmp':
                                case 'gif':
                                    $('#data .image img').one('load', function () { $(this).css({'marginTop':'-' + $(this).height()/2 + 'px','marginLeft':'-' + $(this).width()/2 + 'px'}); }).attr('src',d.content);
                                    $('#data .image').show();
                                    break;
                                default:
                                    $('#data .default').html(d.content).show();
                                    break;
                            }
                        }
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

    <div id="tree"></div>
    <div id="data">
        <div class="content code" style="display:none;"><textarea id="code" readonly="readonly"></textarea></div>
        <div class="content folder" style="display:none;"></div>
        <div class="content image" style="display:none; position:relative;"><img src="" alt="" style="display:block; position:absolute; left:50%; top:50%; padding:0; max-height:90%; max-width:90%;" /></div>
        <div class="content default" style="text-align:center;">Select a file from the tree.</div>
    </div>
</div>
<?php \year\widgets\PageletBlock::end() ?>



