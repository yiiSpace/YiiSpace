<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/8/16
 * Time: 0:45
 */

namespace my\devtools\common\models;


use yii\base\Model;
use yii\helpers\Inflector;

/**
 * Class ApiProvider
 * @package my\devtools\common\models
 */
class ApiProvider extends Model
{

    public $tableName = '';
    public $modelName = '';

    public function rules()
    {
        return [
            [['tableName'], 'required',],
            [['modelName'], 'string',],
        ];
    }


    /**
     * 获取模型名称
     *
     * @return string
     */
    public function getModelName()
    {
        if(!empty($this->modelName)){
            return $this->modelName ;
        }else{
            return $this->generateClassName($this->tableName) ;
        }
    }
    /**
     *
     * COPY FROM GII
     *
     * Generates a class name from the specified table name.
     * @param string $tableName the table name (which may contain schema prefix)
     * @return string the generated class name
     */
    protected function generateClassName($tableName)
    {
        if (($pos = strrpos($tableName, '.')) !== false) {
            $tableName = substr($tableName, $pos + 1);
        }

        $db = \Yii::$app->db ;
        $patterns = [];
        $patterns[] = "/^{$db->tablePrefix}(.*?)$/";
        $patterns[] = "/^(.*?){$db->tablePrefix}$/";
        if (strpos($this->tableName, '*') !== false) {
            $pattern = $this->tableName;
            if (($pos = strrpos($pattern, '.')) !== false) {
                $pattern = substr($pattern, $pos + 1);
            }
            $patterns[] = '/^' . str_replace('*', '(\w+)', $pattern) . '$/';
        }
        $className = $tableName;
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $tableName, $matches)) {
                $className = $matches[1];
                break;
            }
        }
        return  Inflector::id2camel($className, '_');
    }
    /***
     * 获取php类型的默认零值 （思想参考go语言的零值意义）
     *
     * @param string $phpType
     * @return string
     */
    public static function getPhpTypeZeroValue($phpType)
    {
        static $typeMap = [
            // php type => zero value
            'string' => " '' ",
            'integer' => ' 0 ',
            'boolean' => ' true',
            'float' => ' 0.0',
            'float' => ' double',
            'resource' => ' null',
        ];
        if (isset($typeMap[$phpType])) {
            return $typeMap[$phpType];
        } else {
            return ' null';
        }
    }

    /**
     * 表名选择源
     *
     * @return array
     */
    public static function getTableNameOptions()
    {
        $tableNames = self::getTableNames();
        $tableNameMap = array_combine($tableNames, $tableNames) ;
         ksort( $tableNameMap);
        return $tableNameMap ;
    }

    /**
     * @return \string[]
     * @throws \yii\base\NotSupportedException
     */
    public static function getTableNames()
    {
        $db = \Yii::$app->db;
        return $db->getSchema()->getTableNames();
    }

    /**
     * @param string $tableName
     * @return \yii\db\TableSchema
     */
    public static function getTableSchema($tableName = '')
    {
        $db = \Yii::$app->db;
        return $db->getTableSchema($tableName);
    }
}