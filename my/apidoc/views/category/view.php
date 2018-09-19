<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/5/27
 * Time: 12:53
 */

 $apiCategory = reset($apiCategories);
?>
<?php
// TODO 提取到帮助类中
/**
 * 获取控制器id
 * @param $controllerClass
 * @return string
 */
$getControllerId = function($controllerClass){
    $name = \yii\helpers\StringHelper::basename($controllerClass);
    return \yii\helpers\Inflector::camel2id(substr($name, 0, strlen($name) - 10));
} ;

//---------------------------------------------------------------------------------------------------- \\
// 解析方法访问路径
/**
 * @param string $actionName
 * @return string
 */
$getActionId = function($actionName=''){
    $actionName = ltrim($actionName,'action');
    return \yii\helpers\Inflector::camel2id($actionName);
};
//---------------------------------------------------------------------------------------------------- //
?>
<div>

    <h1>
         <?= $apiCategory['shortDescription'] ?>
    </h1>

    <p>

        <?= $apiCategory['description']  ?> ===> <?= $getControllerId($apiCategory['name']) ?>
    </p>


    <div class="ui-table-container ">
        <table class="ui-table  table"><!-- 可以在class中加入ui-table-inbox或ui-table-noborder分别适应不同的情况 -->
            <thead>
            <tr>
                <th>名称</th>
                <th>描述</th>
                <th>访问路径(endPoint path)</th>

            </tr>
            </thead><!-- 表头可选 -->
            <tbody>

            <?php foreach($apiList as $idx =>  $apiItem) : ?>

                <?php
                // 如果方法有ApiDocIgnore 标签 那么忽略掉
                if($apiItem['method']->hasTag('apidocignore')){
                    continue ;
                } ?>

            <tr class="<?= (($idx+1) % 2) == 0 ? 'ui-table-split' : '' ?>">
                <td>
                    <a href="#<?= $apiItem['name'] ?>-detail">
                        <?= $apiItem['name'] ?>
                    </a>

                </td>
                <td>
                    <?= $apiItem['shortDescription'] ?>
                </td>
                <td>
                    <?=  $getControllerId($apiCategory['name']).'/'.$getActionId($apiItem['name']) ?>
                </td>
            </tr>
            <?php endforeach  ?>

            </tbody>
            <tfoot>
            <tr>
                <td colspan="2">

                </td>
            </tr>
            </tfoot><!-- 表尾可选 -->
        </table>
    </div>

</div>

<?php foreach($apiList as $apiItem): ?>
<?= $this->render('_api-item',['method'=>$apiItem['method'],'categoryName'=>$apiItem['categoryName']]) ?>
    <br/>
<?php endforeach ?>

<?php if(YII_DEBUG): ?>
    <div class="alert">
        api类寄居在：<?= $apiCategory['path'] ?>
    </div>
<?php endif ?>
