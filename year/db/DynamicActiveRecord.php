<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/26
 * Time: 10:56
 */

namespace year\db;


use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\db\Schema;

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
class DynamicActiveRecord extends ActiveRecord
{

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
    protected static $tableName;

    /**
     * @param string $tableName
     */
    public static function setTableName($tableName = '')
    {
        static::$tableName = $tableName;

    }

    public static function forTable($tableName, $scenario = 'insert')
    {
        static::setTableName($tableName);
        $ar = new static();
        $ar->setScenario($scenario);
        return $ar;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $db = static::getDb();
        $rules = $this->generateRules($db->getTableSchema(static::tableName()));
        $rulesCode = empty($rules) ? '[]' : ("[\n            " . implode(",\n            ", $rules) . ",\n       ] ");
        return eval('return ' . $rulesCode . ';');
    }

    /**
     * -------------------------------------------------------------------------------------------  +|
     *                  copy from gii
     */
    /**
     * Generates validation rules for the specified table.
     * @param \yii\db\TableSchema $table the table schema
     * @return array the generated validation rules
     */
    protected function generateRules($table)
    {
        $types = [];
        $lengths = [];
        foreach ($table->columns as $column) {
            if ($column->autoIncrement) {
                continue;
            }
            if (!$column->allowNull && $column->defaultValue === null) {
                $types['required'][] = $column->name;
            }
            switch ($column->type) {
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                case Schema::TYPE_TINYINT:
                    $types['integer'][] = $column->name;
                    break;
                case Schema::TYPE_BOOLEAN:
                    $types['boolean'][] = $column->name;
                    break;
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                    $types['number'][] = $column->name;
                    break;
                case Schema::TYPE_DATE:
                case Schema::TYPE_TIME:
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                case Schema::TYPE_JSON:
                    $types['safe'][] = $column->name;
                    break;
                default: // strings
                    if ($column->size > 0) {
                        $lengths[$column->size][] = $column->name;
                    } else {
                        $types['string'][] = $column->name;
                    }
            }
        }
        $rules = [];
        $driverName = $this->getDbDriverName();
        foreach ($types as $type => $columns) {
            if ($driverName === 'pgsql' && $type === 'integer') {
                $rules[] = "[['" . implode("', '", $columns) . "'], 'default', 'value' => null]";
            }
            $rules[] = "[['" . implode("', '", $columns) . "'], '$type']";
        }
        foreach ($lengths as $length => $columns) {
            $rules[] = "[['" . implode("', '", $columns) . "'], 'string', 'max' => $length]";
        }

        $db = static::getDb();

        // Unique indexes rules
        try {
            $uniqueIndexes = array_merge($db->getSchema()->findUniqueIndexes($table), [$table->primaryKey]);
            $uniqueIndexes = array_unique($uniqueIndexes, SORT_REGULAR);
            foreach ($uniqueIndexes as $uniqueColumns) {
                // Avoid validating auto incremental columns
                if (!$this->isColumnAutoIncremental($table, $uniqueColumns)) {
                    $attributesCount = count($uniqueColumns);

                    if ($attributesCount === 1) {
                        $rules[] = "[['" . $uniqueColumns[0] . "'], 'unique']";
                    } elseif ($attributesCount > 1) {
                        $columnsList = implode("', '", $uniqueColumns);
                        $rules[] = "[['$columnsList'], 'unique', 'targetAttribute' => ['$columnsList']]";
                    }
                }
            }
        } catch (NotSupportedException $e) {
            // doesn't support unique indexes information...do nothing
        }

        // Exist rules for foreign keys
        foreach ($table->foreignKeys as $refs) {
            $refTable = $refs[0];
            $refTableSchema = $db->getTableSchema($refTable);
            if ($refTableSchema === null) {
                // Foreign key could point to non-existing table: https://github.com/yiisoft/yii2-gii/issues/34
                continue;
            }
            $refClassName = $this->generateClassName($refTable);
            unset($refs[0]);
            $attributes = implode("', '", array_keys($refs));
            $targetAttributes = [];
            foreach ($refs as $key => $value) {
                $targetAttributes[] = "'$key' => '$value'";
            }
            $targetAttributes = implode(', ', $targetAttributes);
            $rules[] = "[['$attributes'], 'exist', 'skipOnError' => true, 'targetClass' => $refClassName::className(), 'targetAttribute' => [$targetAttributes]]";
        }

        return $rules;
    }

    /**
     * @return string|null driver name of db connection.
     * In case db is not instance of \yii\db\Connection null will be returned.
     * @since 2.0.6
     */
    protected function getDbDriverName()
    {
        /** @var Connection $db */
        $db = static::getDb();
        return $db instanceof \yii\db\Connection ? $db->driverName : null;
    }

    /**
     * Checks if any of the specified columns is auto incremental.
     * @param \yii\db\TableSchema $table the table schema
     * @param array $columns columns to check for autoIncrement property
     * @return bool whether any of the specified columns is auto incremental.
     */
    protected function isColumnAutoIncremental($table, $columns)
    {
        foreach ($columns as $column) {
            if (isset($table->columns[$column]) && $table->columns[$column]->autoIncrement) {
                return true;
            }
        }

        return false;
    }
    /**
     * --------------------------------------------------------------------------------------------  +|
     *     ## eval  的替代方案  可以动态生成一个php文件 然后包含进来 | 也可以生runtime目录下 不用删除
     */
    /**
     * https://stackoverflow.com/questions/684553/convert-php-array-string-into-an-array
     * ~~~php
     *
     * $myArray = array('key1'=>'value1', 'key2'=>'value2');
     * $fileContents = '<?php $myArray = '.var_export($myArray, true).'; ?>';
     *
     * // ... after writing $fileContents to 'myFile.php'
     *
     * include 'myFile.php';
     * echo $myArray['key1']; // Output: value1
     *
     * ~~~
     */

    /**
     * @see http://php.net/manual/zh/function.tmpfile.php
     *
     * @param $name
     * @param $content
     * @return string
     */
    function temporaryFile($name, $content)
    {
        $file = DIRECTORY_SEPARATOR .
            trim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) .
            DIRECTORY_SEPARATOR .
            ltrim($name, DIRECTORY_SEPARATOR);

        file_put_contents($file, $content);

        register_shutdown_function(function () use ($file) {
            unlink($file);
        });

        return $file;
    }
    /**
     * --------------------------------------------------------------------------------------------   +|
     */

}