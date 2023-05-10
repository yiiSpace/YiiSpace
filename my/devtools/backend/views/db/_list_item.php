<?php
// _list_item.php
use yii\db\TableSchema;
use yii\helpers\Html;
use yii\helpers\Url;
/** @var yii\web\View $this */
/** @var array $model */
/** @var TableSchema $tableSchema */
/** @var \yii\db\ColumnSchema $columnSchema */



$tableSchema = $model['tableSchema'] ;
/**
 * @var array $columnNames
 */
$columnNames = $tableSchema->getColumnNames() ;

//TODO：需要针对某个表 在线设计一个Facker（https://fakerphp.github.io/ 这个目前跟yii内置的有冲突只能选yii2的了） 填充的类 对每个字段都可以选择或者输入部分代码

?>

<div class="card" style="width: auto;">
    <div class="card-body">
        <h5 class="card-title  >
        <p class="text-primary">

            <?= $model['id'] ?>
        </p>

        </h5>
        <p class="card-text">
            <?php
            // TODO 这里没办法获取到表本身的注释么
            ?>
        </p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">
                   字段
                </th>
                <th scope="col">
                  类型
                </th>
                <th scope="col">
                  注释
                </th>
            </tr>
            </thead>
            <tbody>
            <?php   foreach ($columnNames as $columnName):
            $columnSchema = $tableSchema->getColumn($columnName) ;
            ?>
            <tr>
<!--                <th scope="row">1</th>-->
                <td>
                    <?=  $columnSchema->name ?>
                </td>
                <td>
                    <?=  $columnSchema->phpType ?>
                    <?php  //\Faker\Factory:: ?>
                </td>
                 <td>
                    <?=  $columnSchema->comment ?>
                </td>

            </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
        </li>
        <li class="list-group-item">
          ---
        </li>
    </ul>
    <div class="card-body">
        <a href="#" class="card-link">Card link</a>
        <a href="#" class="card-link">Another link</a>
    </div>
</div>
