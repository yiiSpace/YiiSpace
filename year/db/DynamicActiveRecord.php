<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/26
 * Time: 10:56
 */

namespace year\db;


use backend\components\DbMan;
use yii\base\InvalidParamException;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\db\Schema;

/**
 * FIXME 最新版的yii2 已经有动态AR类了 请确认下
 * 
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

    protected static $db ;

    public static function setDbID($dbId)
    {
        if(\Yii::$app->has($dbId)){

           static::$db = $dbId ;
        }else{
//            throw new InvalidParamException()
            throw new \InvalidArgumentException(''.$dbId.' is not exist! make sure you bootstrap the '.DbMan::class);
        }
    }

    /**
     * @return string
     */
    public static function getDbID()
    {
        return static::$db ;
    }
    /**
     * Returns the database connection used by this AR class.
     * By default, the "db" application component is used as the database connection.
     * You may override this method if you want to use a different database connection.
     * @return Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        $dbId = static::$db ;
        if(empty($dbId)){
            // TODO 这里为了动态设置不同的db 可以留个设置db的地方 然后拿到这个db_id  后从这里返回 db注入必须先于此类的使用
            return \Yii::$app->getDb();
        }else{
            return \Yii::$app->get($dbId) ;
        }

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
     * // 动态表单的 名称如果按照默认实现是用反射取短名称的
     *
     * @return string
     */
    public function formName()
    {
//        $reflector = new ReflectionClass($this);
//        if (PHP_VERSION_ID >= 70000 && $reflector->isAnonymous()) {
//            throw new InvalidConfigException('The "formName()" method should be explicitly defined for anonymous models');
//        }
//        return $reflector->getShortName();
        return static::$tableName ;
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

    /**
     * @see https://gist.github.com/blacksmoke26/0b6addf05212997aded7878c2939d02d
     *
     * <code>
     * $model = Model::getRandom(null, [
    * 'asArray'=>true
       ]);
     * \yii\helpers\VarDumper::dump($mode, 10, true);
     *
     * </code>
     *
     * Get random model(s) from table
     * @see \yii\db\ActiveQuey
     * @param array|string|null (optional) $columns Columns to be fetched (default: all columns)
     * @param array $options Additional options pass to function<br>
     * <code>
     *  (array) condition Where Condition
     *  (int) limit Number of models (default: 1)
     *  (bool) asArray Return model attributes as [key=>value] array
     *  (callable) callback Apply a callback on ActiveQuery
     *    function ( \yii\db\ActiveQuery $query ){
     *      // some logic here ...
     *    }
     * </code>
     * @return array|null|\yii\db\ActiveRecord|\yii\db\ActiveRecord[]
     */
    public static function getRandom( $columns = null, array $options = [] ) {
        $condition = $options['condition'] ?? [];
        $asArray = $options['asArray'] ?? false;
        $callback = $options['callback'] ?? null;
        $limit = $options['limit'] ?? 1;

        $query = static::find()
            ->select($columns)
            ->where($condition)
            ->orderBy(new \yii\db\Expression('rand()'))
            ->limit((int)$limit);

        if ( $asArray ) {
            $query->asArray(true);
        }

        if ( is_callable($callback) ) {
            call_user_func_array($callback, [&$query]);
        }

        return $limit === 1
            ? $query->one()
            : $query->all();
    }


}