<?php
/**
 * This is the template for generating the migration class of a specified table.
 * DO NOT EDIT THIS FILE! It may be regenerated with Gii.
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var \year\gii\models\generators\gomodel\Generator $generator
 * @var string $tableName full table name
 * @var \yii\db\TableSchema $tableSchema
 * @var array $primaryKey
 */

//   $generator->tableName
$goColumnsMeta = $generator->columnsMetaData($giiConsolePath) ;

/** @var  $getColumnSchemaFn */
$getColumnSchemaFn = function ($colName)use(   $tableSchema ) {
  return  $tableSchema->getColumn($colName) ;
};

$dbFields2goFieldsMap = [] ;
foreach ($properties as $property => $data){
    if(isset($goColumnsMeta[$property])){
        $goColType =  ($goColumnsMeta[$property]['GoType']) ;
    }else{
        $goColType = $data['type'] ; // FIXME 用php先替代
    }
    $goProp = Inflector::id2camel($property, '_');
    $dbFields2goFieldsMap[$property] = [
      'structField'=>$goProp,
      'comment'=>$data['comment'],
    ];
}

?>

{{template "base" .}}

{{define "title"}} <?= $className ?> #{{.<?= $dbFields2goFieldsMap[$primaryKey[0]]['structField']  ?>}} {{end}}

{{define "body"}}
<div class='<?= Inflector::camel2id($className,'-') ?>'>
    <dl>
    <?php foreach ($dbFields2goFieldsMap as $dbField => $goFieldInfo): ?>
        <dt><?= $dbField ?></dt>
        <dd>{{.<?= $goFieldInfo['structField'] ?>}}</dd>

    <?php endforeach;  ?>
    </dl>
</div>
{{end}}


