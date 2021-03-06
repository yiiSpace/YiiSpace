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

// @see github.com/smallnest/gen
/**
 *  sql-null 和guregu-null 稍有不同哦  注意取64位是因为这个是通吃兜底类型 比如Int64 范围要比： int32 int 更广
 *
    gureguNullInt    = "null.Int"
    sqlNullInt       = "sql.NullInt64"
    golangInt        = "int"
    golangInt64      = "int64"
    gureguNullFloat  = "null.Float"
    sqlNullFloat     = "sql.NullFloat64"
 *
 * @see https://blog.csdn.net/westhod/article/details/81456898
 * 假如字段类型为date、timestamp等，该对应哪种呢？通常第三方的类库会转为string类型，那么就对应sql.NullString好了。
 */


?>
package models

import (
    // "github.com/go-ozzo/ozzo-validation"
    "time"

    "gopkg.in/guregu/null.v3"
    "database/sql"
)
var (
    _ = time.Second
    _ = sql.LevelDefault
    _ = null.Bool{}
)

type <?=  $className ?> struct {
//   Id          int    `json:"id"` // int32

<?php foreach ($properties as $property => $data): ?>
    <?php
    if(isset($goColumnsMeta[$property])){
       $goColType =  ($goColumnsMeta[$property]['GoType']) ;
    }else{
        $goColType = $data['type'] ; // FIXME 用php先替代
    }
    if($generator->handleNullColumn && $getColumnSchemaFn($property)->allowNull){
        $goColType = 'null.'.ucfirst($goColType) ;
    }

    $prop = Inflector::id2camel($property, '_');
    // 描述形式： " `name` VARCHAR(64) NOT NULL "  需要做一下处理
    // $xormFieldDescription = trim($data['description']) ;
   // $xormFieldDescription = substr($xormFieldDescription,strpos($xormFieldDescription,' '))
    ?>
    <?= "\t {$prop}  $goColType  " . (" `json:\"{$property}\"  `  ") . "   //  " . ($data['comment'] ? ' ' . strtr($data['comment'], ["\n" => ' ']) : '') . "\n" ?>
<?php endforeach; ?>

// 依赖 Repo  可以用来做一些唯一性检测的验证约束
// repo <?= $className ?>Repo `json:"-" form:",omitempty"` //
}

<?php if($generator->genTableName):  ?>
// TableName sets the insert table name for this struct type
func (model *<?= $className ?>) TableName() string {
    return "<?= $tableName ?>"
}
<?php endif; ?>

