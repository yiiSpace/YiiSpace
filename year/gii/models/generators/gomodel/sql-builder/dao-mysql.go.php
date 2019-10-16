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
 * @var array $primaryKey
 */

//   $generator->tableName
$goColumnsMeta = $generator->columnsMetaData($giiConsolePath) ;

$packageName = 'mysql';
$imports = [] ;

$daoClassName = $className.'DAO' ;
$shortModelName = '';
foreach (explode('_',$tableName) as $idx=>$part){
    $shortModelName .= $part[0] ;
}

// 收集db字段到go结构体字段的 映射
$dbFields2goFields = [];
foreach ($properties as $property=>$data){
    if(isset($goColumnsMeta[$property])){
        $goColType =  ($goColumnsMeta[$property]['GoType']) ;
    }else{
        $goColType = $data['type'] ; // FIXME 用php先替代
    }
    $prop = Inflector::id2camel($property, '_');
    $dbFields2goFields[$property] = $prop ;
}

$dbFields2goFieldsWithoutPks = array_filter($dbFields2goFields,function ($k)use($primaryKey){
    return !in_array($k,$primaryKey) ;
},ARRAY_FILTER_USE_KEY);

$getSql = "SELECT ".implode(', ',array_keys($dbFields2goFields))
    ." FROM ".$tableName ;

// 搜索语句WHERE前的片段跟getSql一致
$querySql = $getSql ;

// FIXME $primaryKey  针对无主键情况 可能是空数组
if(count($primaryKey) == 0) {
    $getSql .= " WHERE id = ?" ;
}else{
    $getSql .=  " WHERE ".implode(' AND ', array_map(function($item){
        return  $item.'=? ' ;
    },$primaryKey));
}

$insertSql = "INSERT INTO {$tableName}(" .implode(', ',array_keys($dbFields2goFieldsWithoutPks)).') ' ;
// FIXME 这里用str_repeat() 也可以哦！
$insertSql .= "VALUES(". implode(', ',array_fill(0,count($dbFields2goFieldsWithoutPks),'?'))
                .')';

$insertExecArgs = implode(' ,',array_map(function($item){
    return 'model.'.$item ; // 这里是写死了模型名称 go里面还经常用短名称
},$dbFields2goFieldsWithoutPks));

// 对应的go结构体字段
$correspondingGoFields = array_values($dbFields2goFields) ;
$scanGoFields = array_map(function($item){
    return '&model.'.$item ;
}, $correspondingGoFields);
$scanGoFields = implode(' ,', $scanGoFields) ;

$scanGoFieldsFn = function ($prefix = '&model.')use($correspondingGoFields){
    $scanGoFields = array_map(function($item)use($prefix){
        return $prefix.$item ;
    }, $correspondingGoFields);
    $scanGoFields = implode(' ,', $scanGoFields) ;
    return $scanGoFields ;
};


$deleteSql = "DELETE FROM {$tableName} WHERE ";
if(count($primaryKey) == 0) {
    $deleteSql .= " WHERE id = ?" ;
}else{
    $deleteSql .=  " WHERE ".implode(' AND ', array_map(function($item){
            return  $item.'=? ' ;
        },$primaryKey));
}

// ## update
$updateSql = "UPDATE {$tableName} SET ";
$updateSql .= implode(', ',array_map(function ($item){
    return $item.'=?' ;
},array_keys($dbFields2goFieldsWithoutPks)));
if(count($primaryKey) == 0) {
    $updateSql .= " WHERE id = ?" ;
}else{
    $updateSql .=  " WHERE ".implode(' AND ', array_map(function($item){
            return  $item.'=? ' ;
        },$primaryKey));
}
$updateExecArgs = $insertExecArgs ; // 更新和插入执行参数一致的

$countSql = "SELECT COUNT(*) FROM {$tableName} " ;

?>
package <?= $packageName ?>

// short model name is : <?= $shortModelName ?>

import (
	// "github.com/qiangxue/golang-restful-starter-kit/app"
	// "github.com/qiangxue/golang-restful-starter-kit/models"
    sq "github.com/Masterminds/squirrel"
    "database/sql"
)

// PK: <?= print_r($primaryKey, true) ?>

// <?= $daoClassName ?> persists <?= $tableName ?> data in database
type <?= $daoClassName ?> struct{
    DB *sql.DB
}

// New<?= $daoClassName ?> creates a new <?= $daoClassName ,"\n"?>
func New<?= $daoClassName ?>(db *sql.DB) *<?= $daoClassName?> {
	return &<?= $daoClassName ?>{
        DB: db,
    }
}

// Get reads the <?= $tableName ?> with the specified ID from the database.
func (dao *<?= $daoClassName ?>) Get(id int) (*models.<?= $className ?>, error) {
	var model models.<?= $className ?>

    <?php $columns4select = array_map(function ($item){
        return '"'.$item.'"';
    },array_keys($dbFields2goFields)) ?>
    b := sq.Select(<?= join(', ',$columns4select) ?>).From("<?= $tableName ?>")
    b = b.Where(sq.Eq{"<?= $primaryKey[0] ?>": id}) // 复合主键情况自己处理 这里只处理大部分情形
    sql, args, err := b.ToSql()
    if err != nil {
        return nil , err
    }

    //
    err := dao.DB.QueryRow(sql, args...).Scan(<?= $scanGoFields ?>)
    if err != nil {
        return nil , err
    }

	return &model, nil
}

// Create saves a new <?= $tableName ?> record in the database.
// The <?= $className ?>.Id field will be populated with an automatically generated ID upon successful saving.
func (dao *<?= $daoClassName ?>) Create(model *models.<?= $className ?>) error {
    <?php $columns2 = array_map(function ($item){
        return '"'.$item.'"';
    },array_keys($dbFields2goFieldsWithoutPks)) ?>
    sql, args, err := sq.
    Insert("<?= $tableName ?>").Columns(<?= join(', ',$columns2) ?>).
    Values(<?= $insertExecArgs ?>). //.Values("larry", sq.Expr("? + 5", 12)).
    ToSql()
    if err != nil {
         return err //log.Fatal(err)
    }


    stmt, err := dao.DB.Prepare(sql)
    if err != nil {
         return err //log.Fatal(err)
    }
    res, err := stmt.Exec(args...)
    if err != nil {
         return err	//log.Fatal(err)
    }
    lastId, err := res.LastInsertId()
    if err != nil {
         return err// log.Fatal(err)
    }
    rowCnt, err := res.RowsAffected()
    if err != nil {
         return  err // log.Fatal(err)
    }
    log.Printf("ID = %d, affected = %d\n", lastId, rowCnt)
    return nil
}

// Update saves the changes to an <?= $tableName ?> in the database.
func (dao *<?= $daoClassName ?>) Update(id int, model *models.<?= $className ?>) error {
	if _, err := dao.Get(id); err != nil {
		return err
	}
    <?php  $setMap = [] ;
        foreach ($dbFields2goFieldsWithoutPks as $dbField => $goField){
            $setMap[] = '"'.$dbField.'":'.'model.'.$goField ;
        }
    ?>

    b := sq.Update("<?= $tableName ?>").
    SetMap(sq.Eq{<?= join(', ', $setMap) ?>}).
    Where(sq.Eq{"<?= $primaryKey[0] ?>": id})

    sql, args, err := b.ToSql()
    if err != nil {
         return err
    }

    stmt, err := dao.DB.Prepare(sql)
    if err != nil {
        return err
    }

    res, err := stmt.Exec(args...)


    if err != nil {
        return err
    }
    rowCnt, err := res.RowsAffected()
    if err != nil {
        return err
    }
    log.Printf("ID = %d, affected = %d\n", id, rowCnt)
    return nil
}

// Delete deletes an <?= $tableName ?> with the specified ID from the database.
func (dao *<?= $daoClassName ?>) Delete( id int ) error {
	model, err := dao.Get(id)
	if err != nil {
		return err
	}
    _ = model

    b := sq.Delete("<?= $tableName ?>").Where("id = ?", id)
    sql, args, err := b.ToSql()
    if err != nil {
        return err
    }

    stmt, err := dao.DB.Prepare(sql)
    if err != nil {
         return err
    }
    <?php if(count($primaryKey) !=1 ): ?>
        //  panic(fmt.Sprintf(""...)) or panic(errors.Errorf("primary key count is : %d ",1))
        panic("table primary key numbers is : <?= count($primaryKey) ?>")
        res, err := stmt.Exec(args...) // 无主键或者多主键情况 需要特殊处理 不然会删除有问题

    <?php else: ?>
    res, err := stmt.Exec(args...)
    <?php endif; ?>

    if err != nil {
         return err
    }
    rowCnt, err := res.RowsAffected()
    if err != nil {
         return err // log.Fatal(err)
    }
    log.Printf("ID = %d, affected = %d\n", id, rowCnt)
    return nil
}

// Count returns the number of the <?= $tableName ?> records in the database.
func (dao *<?= $daoClassName ?>) Count() (int, error) {
	var count int

    // TODO 后续可以传递一个搜索模型 继续添加 WHERE 子句部分
    sql, _, err := sq.Select("COUNT(*)").From("<?= $tableName ?>").Where(nil).ToSql()
    if err != nil {
         return 0, err
    }
    err = dao.DB.QueryRow(sql).
    Scan(&count)
    if err != nil {
          return 0, err
    }
	return count, nil
}

// Query retrieves the <?= $tableName ?> records with the specified offset and limit from the database.
func (dao *<?= $daoClassName ?>) Query(/*qm queryModel*/ offset, limit int) ([]models.<?= $className ?>, error) {
	rs := []models.<?= $className ?>{}
	// err := rs.Tx().Select().OrderBy("id").Offset(int64(offset)).Limit(int64(limit)).All(&models)
    querySql := fmt.Sprintf("<?= $querySql ?> LIMIT %d OFFSET %d",limit,offset)


    b := sq.Select(<?= join(', ',$columns4select) ?>).
    From("<?= $tableName ?>").
    //   Where(map[string]interface{}{"h": 6}).
    //   Where(Or{Expr("j = ?", 10), And{Eq{"k": 11}, Expr("true")}}).
    //   OrderByClause("? DESC", 1).
    //   OrderBy("o ASC", "p DESC").
    Limit(limit).
    Offset(offset)
    // Suffix("FETCH FIRST ? ROWS ONLY", 14)

    sql, args, err := b.ToSql()
    if err != nil {
         return rs , err
    }
    rows, err = dao.DB.Query(sql)
    if err != nil {
         return rs , err
    }
    defer rows.Close()

    for rows.Next() {
        var m models.User
        err = rows.Scan(<?= $scanGoFieldsFn('&m.') ?>)
        if err != nil {
            return nil, err
        }
            rs = append(rs, m)
    }

    err = rows.Err()
    if err != nil {
      return nil , err
    }
    return rs, nil
}


func (dao *<?= $daoClassName ?>) buildSearchCond(sm models.<?= $className ?>) (sql string, args []interface{}) {

    cond := sq.And{
       <?= implode("\n",$searchConditions()) ?>
    }
    // 构造条件子句
    sql, args, _ = cond.ToSql()

    return sql, args

}