<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/5/27
 * Time: 14:09
 */

/** @var $method  yii\apidoc\models\MethodDoc */
if($method->hasTag('apidocignore')){
   return ;
}

//=====================================================================================================\\
//  post 参数的注解处理
/**
 * @param \phpDocumentor\Reflection\DocBlock\Tag[] $tags
 * @param string $name
 * @return null|\phpDocumentor\Reflection\DocBlock\Tag
 */
$getTags = function($tags ,$name){
    foreach ($tags as $tag) {
        if (strtolower($tag->getName()) == $name) {
            return   $tag;
        }
    }
    return null ;
} ;

$tags = $method->tags ;
print_r(array_map(function($item){return $item->getName(); },$tags));

if($method->hasTag(strtolower('PostParams'))){
    // var_dump( call_user_func('getTag',$method->tags,'postparams')) ;
    /**
     * @var \phpDocumentor\Reflection\DocBlock\Tag $objTag
     */
    $objTag = null ;
    $content = '' ;
    foreach ($tags as $tag) {
        if (strtolower($tag->getName()) == 'postparams') {
            $objTag[] =  $tag;
            // $content .= $tag->getContent().'<br/>'.$tag->getDescription() ;
            $content .= '<br/>'.$tag->getDescription() ;
            ;
        }
    }
    print_r($content) ;
}
//=====================================================================================================//

//---------------------------------------------------------------------------------------------------- \\
// 解析方法访问路径
$getActionId = function($actionName){
   $actionName = ltrim($actionName,'action');
    return \yii\helpers\Inflector::camel2id($actionName);
};

//---------------------------------------------------------------------------------------------------- //

   \year\editor\JSONEditorAsset::register($this); //
// \year\editor\FlexiJsonEditorAsset::register($this) ;
?>


<div class="ui-box" id="<?= $method->name ?>-detail">
    <div class="ui-box-head">
        <h3 class="ui-box-head-title">
            <?= $method->name ?>
        </h3>
        <span class="ui-box-head-text">
            <?= $method->shortDescription ?>
        </span>
        <a href="#" class="ui-box-head-more">
           <?php // $getActionId($method->name) ?>
        </a>
    </div>
    <div class="ui-box-container">
        <div class="ui-box-content">
            <?php //print_r($method) ?>

            <div class="ui-table-container">
                <table class="ui-table ui-table-inbox table"><!-- 可以在class中加入ui-table-inbox或ui-table-noborder分别适应不同的情况 -->
                    <thead>
                    <?php if (count($method->params) > 0): ?>
                        <tr>
                            <th>参数名称</th>
                            <th>类型</th>
                            <th>是否必须</th>
                            <th>默认值</th>
                            <th>描述</th>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <th>无输入参数</th>
                        </tr>
                    <?php endif ?>
                    </thead>
                    <!-- 表头可选 -->
                    <tbody>

                    <?php
                    $params = $method->params;
                    foreach ($params as $idx => $param):
                        ?>
                        <tr class="<?= ($idx + 1) % 2 == 0 ? 'ui-table-split' : '' ?>">
                            <td>
                                <?= ltrim($param->name,'$') ?>
                            </td>
                            <td>
                                <?= $param->type ?>
                            </td>
                            <td>
                                <?= (!$param->isOptional) ? '是' : '否' ?>
                            </td>
                            <td>
                                <?= $param->defaultValue ?>
                            </td>
                            <td>
                                <?= \yii\helpers\Markdown::process($param->description) ?>
                            </td>

                        </tr>
                    <?php endforeach ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="ui-box ui-box-follow">
    <div class="ui-box-head">
        <h3 class="ui-box-head-title">返回结果</h3>
        <span class="ui-box-head-text">

        </span>
        <a href="#" class="ui-box-head-more">

        </a>
    </div>
    <div class="ui-box-container">
        <div class="ui-box-content">

            <div class="ui-table-container">
                <table class="ui-table ui-table-inbox table"><!-- 可以在class中加入ui-table-inbox或ui-table-noborder分别适应不同的情况 -->
                    <thead>
                    <tr>
                        <th>类型</th>

                        <th>描述</th>
                    </tr>
                    </thead>
                    <!-- 表头可选 -->
                    <tbody>


                    <tr class="ui-table-split">
                        <td>
                            <?= $method->returnType ?>
                        </td>

                        <td>
                            <?php // \yii\apidoc\helpers\ApiMarkdown::process($method->return, null, true)?>
                            <?=  \yii\helpers\Markdown::process($method->return)?>
                            <?php // $method->return ?>
                            <?= \yii\helpers\Html::a('测试',['/api-tools','method'=> lcfirst( substr($categoryName ,0, strpos($categoryName, 'Service') )).'.'. $method->name],['target'=>'_blank']) ?>
                        </td>
                        <!--         <td>    <?php // echo   var_export($method,true) ?>   </td>                -->


                    </tr>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
\year\widgets\JsBeautifyAsset::register($this) ;
// google prettify js
\year\widgets\PrettifyAsset::register($this);
// \year\widgets\PrettifyAsset::applyTheme(\year\widgets\PrettifyAsset::getRandomTheme()) ;
\year\widgets\PrettifyAsset::applyColorTheme(\year\widgets\GoogleCodePrettifyTheme::getRandomTheme()) ;
?>


<?php \year\widgets\JsBlock::begin() ?>
<script>
    $(function(){
       /*
        $('code').each(function(){
            // var container = document.getElementById("jsoneditor");
            var container = this;
            var options = {
                mode: 'view'
            };
            var editor = new JSONEditor(container, options);

            var json = $(this).text();

            editor.set(json);
        });
        */
        $('code').each(function(){

                console.log(this);
            $(this).text(js_beautify($(this).text()))
                .wrap('<pre class="prettyprint" ></pre>'); // 加这行才能原样输出！

        });
        // 只调用一次
        function prettify(){
            var cnt = 0 ;
            return function()
            {
                if(cnt !== 0 ){
                    return  ;
                }

                prettyPrint();
                cnt = cnt + 1 ;
            }
        }
        // 调用
        prettify()();
    }) ;


</script>
<?php \year\widgets\JsBlock::end() ?>