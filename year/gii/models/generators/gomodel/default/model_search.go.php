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

$searchModelName = $className.'Search' ;


?>
package models

import (
    // "github.com/go-ozzo/ozzo-validation"
)


type <?=  $searchModelName ?> struct {
<?= $className ?>
<?php foreach ($properties as $property => $data): ?>
    <?php
    $prop = Inflector::id2camel($property, '_');
    if(isset($goColumnsMeta[$property])){
       $goColType =  ($goColumnsMeta[$property]['GoType']) ;
    }else{
        $goColType = $data['type'] ; // FIXME 用php先替代
    }
    ?>
<?php  if($generator->handleNullColumn && $getColumnSchemaFn($property)->allowNull):
   // $goColType = 'null.'.ucfirst($goColType) ;
?>
    <?= "\t {$prop}  $goColType  " . (" `json:\"{$property}\"  `  ") . "   //  " . ($data['comment'] ? ' ' . strtr($data['comment'], ["\n" => ' ']) : '') . "\n" ?>
<?php endif; ?>
<?php endforeach; ?>
}
// Validate validates the <?= $className ?> fields.
func (m <?= $searchModelName ?>) Validate() error {
    // 搜索模型跟领域模型的验证条件有些不一样 应对场景也不一样 搜索面向读场景 领域模型写场景比重大些
    // return validation.ValidateStruct(&m,
    //     validation.Field(&m.Title /* validation.Required,*/, validation.Length(0, 120)),
    // )
}
