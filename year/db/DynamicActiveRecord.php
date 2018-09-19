<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/26
 * Time: 10:56
 */

namespace year\db;


use yii\db\ActiveRecord;

/**
 * @todo 如果不具有rules规则添加的方法 那么该类属于只读的
 *
 * 本类是全局可访问的 如果在一次请求流程中 多次用到对不同的表 那么每次都应该传递表名进来（ 后期支持添加rules规则 ）
 *
 * 动态表单 就为了方便使用AR提供的一些API 而不需要为每张表生一个模型出来  对应pivot-table的操作比较方便 不然还要使用
 * 底层的ADO操作了！
 *
 * Class DynamicActiveRecord
 * @package year\db
 */
class DynamicActiveRecord extends ActiveRecord{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return static::$tableName;
    }

    /**
     * @var string
     */
    protected static $tableName ;

    /**
     * @param string $tableName
     */
    public static function setTableName($tableName='')
    {
        static::$tableName = $tableName ;

    }

    public static function forTable($tableName, $scenario = 'insert')
    {
        static::setTableName($tableName);
        $ar = new static();
        $ar->setScenario($scenario) ;
        return $ar ;
    }


}