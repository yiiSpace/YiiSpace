<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/5/27
 * Time: 14:09
 */

/** @var $method  yii\apidoc\models\MethodDoc */
if ($method->hasTag('apidocignore')) {
    return;
}
/**
 * 忽略生成文档的的方法
 *
 * 这些逻辑可以保留到module的公共变量 这样可以通过配置做
 */
if (in_array($method->name, ['beforeMethod', 'afterMethod', 'verbs'])) {
    return;
}

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
            <br/>
<!--            <span class="lead"></span>-->
                <blockquote>
                    <?= $method->description ?>
                </blockquote>

        </span>
            <a href="#" class="ui-box-head-more">

            </a>
        </div>
        <div class="ui-box-container">
            <div class="ui-box-content" style="margin-top: 10px">
                <?php // print_r($method) ?>
                <div class="alert alert-info" role="alert">
                    <?php
                    if ($method->hasTag('httpmethod')):
                        $httpMethodTag = \my\apidoc\helpers\PhpDoc::getTag($method->tags, 'HttpMethod');
                        ?>
                        HttpMethod:
                        <span class="label label-info"><?= $httpMethodTag->getContent() ?></span>
                    <?php else : ?>

                        HttpMethod:
                        <span class="label label-info">ANY</span>
                    <?php endif ?>
                </div>

                <div class="ui-table-container">
                    <table class="ui-table ui-table-inbox table">
                        <!-- 可以在class中加入ui-table-inbox或ui-table-noborder分别适应不同的情况 -->
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
                                    <?= ltrim($param->name, '$') ?>
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
                                    <?= $param->description ?>
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
                    <table class="ui-table ui-table-inbox table">
                        <!-- 可以在class中加入ui-table-inbox或ui-table-noborder分别适应不同的情况 -->
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
                                <?= \yii\helpers\Markdown::process($method->return) ?>
                                <?php // $method->return ?>
                                <?= \yii\helpers\Html::a('测试', ['/api-tools', 'method' => lcfirst(substr($categoryName, 0, strpos($categoryName, 'Service'))) . '.' . $method->name], ['target' => '_blank']) ?>
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
\year\widgets\JsBeautifyAsset::register($this);
// google prettify js
\year\widgets\PrettifyAsset::register($this);
// \year\widgets\PrettifyAsset::applyTheme(\year\widgets\PrettifyAsset::getRandomTheme()) ;
\year\widgets\PrettifyAsset::applyColorTheme(\year\widgets\GoogleCodePrettifyTheme::getRandomTheme());
?>


<?php \year\widgets\JsBlock::begin() ?>
    <script>
        $(function () {
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
            $('code').each(function () {

                console.log(this);
                $(this).text(js_beautify($(this).text()))
                    .wrap('<pre class="prettyprint" ></pre>'); // 加这行才能原样输出！

            });
            // 只调用一次
            function prettify() {
                var cnt = 0;
                return function () {
                    if (cnt !== 0) {
                        return;
                    }

                    prettyPrint();
                    cnt = cnt + 1;
                }
            }

            // 调用
            prettify()();
        });


    </script>
<?php \year\widgets\JsBlock::end() ?>