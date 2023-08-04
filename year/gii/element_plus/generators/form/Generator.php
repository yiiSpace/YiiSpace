<?php

namespace year\gii\element_plus\generators\form;

use backend\components\DbMan;
use backend\controllers\DynamicController;
use common\components\ConsoleAppHelper;
use year\db\DynamicActiveRecord;
use year\gii\common\helpers\GiiantFaker;
use year\gii\migration\Config;
use Yii;
use yii\base\NotSupportedException;
use yii\db\Schema;
use yii\gii\CodeFile;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use schmunk42\giiant\helpers\SaveForm;
use yii\helpers\VarDumper;
use yii\web\Response;

/**
 * This generator will generate one or multiple migration for the specified database table.
 *
 * @author yiqing
 *
 * @since 0.0.1
 *
 *  todo: 应该同时具有crud 和 model生成需要的一些方法 可以从crud-generator中拷贝一些代码过来
 * @see yii\gii\generators\crud\Generator
 */
//class Generator extends \schmunk42\giiant\generators\model\Generator
class Generator extends \yii\gii\generators\model\Generator
{


    /**
     * Action to get tablenames.
     *
     * @return string|array
     * @since 0.0.2
     */
    public function actionTableNames()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        //        ob_start();
        //       var_dump($this->getDbConnection());
        //        $content = ob_get_clean();

        $db = $this->getDbConnection();


        $tableNames = [];
        $schema = '';


        //            return [
        //                $this->db ,
        //                $content,
        //                $db->getSchema()->getTableNames('',true),
        ////                $this->getTableNames(),
        //            ];


        return $db->getSchema()->getTableNames($schema, true);
    }


    public $singularEntities = false;

    /**
     * @var null string for the table prefix, which is ignored in generated class name
     */
    public $tablePrefix = null;

    // protected function getDbConnection()
    // {
    //     if (Yii::$container->has($this->db)) {
    //         return Yii::$container->get($this->db);
    //     } else {
    //         return Yii::$app->get($this->db);
    //     }
    // }
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        // 设置默认值 此处可以通过读取Yii的配置参数获取 比如 : Yii::$app->params['migration_src_dir'];
        if (empty($this->srcDir)) {
            $this->srcDir = Yii::getAlias('@app/runtime')
                . DIRECTORY_SEPARATOR . 'forms';
        }
    }

    /**
     * @var string
     */
    public $srcDir;


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gii-element-plus-form Generator';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '此生成器针对特定的数据库表 生成 表单';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {


        //  $rules = parent::rules();
        $rules = array_merge(
            [
                [['template'], 'required', 'message' => 'A code template must be selected.'],
                [['template'], 'validateTemplate'],
            ],
            [
                [['db', 'tableName',], 'filter', 'filter' => 'trim'],


                [['db', 'tableName',], 'required'],
                [['db',], 'match', 'pattern' => '/^\w+$/', 'message' => 'Only word characters are allowed.'],
                [['tableName'], 'match', 'pattern' => '/^([\w ]+\.)?([\w\* ]+)$/', 'message' => 'Only word characters, and optionally spaces, an asterisk and/or a dot are allowed.'],
                //                [['db'], 'validateDb'],
                //                [['tableName'], 'validateTableName'],
            ]
        );
        /*
        $requiredRule = function ($rule) {
            return $rule[1] != 'required';
        };
        $rules = array_filter($rules, $requiredRule);
        */
        $rules = array_merge(
            $rules,
            [
                [['template'], 'required', 'message' => 'A code template must be selected.'],

                [['db', 'tableName',], 'required'],

                [['tablePrefix'], 'safe'],

                ['srcDir', 'string', 'message' => 'migration 项目的 src目录路径'],
                [['srcDir',], 'required', 'message' => '你的migration项目src目录 本程序的路径：' . Yii::$app->basePath],

            ]
        );
        return $rules;
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'srcDir' => '表单的src目录路径',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function hints()
    {
        $srcDir = Yii::$app->basePath;
        return array_merge(
            parent::hints(),
            [
                'srcDir' => '默认路径是 项目根目录 ../xxx/src' . $srcDir,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getTableNames()
    {
        // die($this->db) ;
        return parent::getTableNames();
    }

    /**
     * {@inheritdoc}
     */
    public function requiredTemplates()
    {
        return [
            /*'models/model.js.php',*/
            //'model.vue.php',
            'form.php',

        ];
    }

    public $generateLabelsFromComments = true;

    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        // 见鬼了! 上面分明设置的是true 为啥得到的是false 只能用这种方法搞
        $this->generateLabelsFromComments = (1 == 1);

        $files = [];
        $db = $this->getDbConnection();

        foreach ($this->getTableNames() as $tableName) {


            $tableSchema = $db->getTableSchema($tableName);
            /*
            $className = php_sapi_name() === 'cli'
                ? $this->generateClassName($tableName)
                : $this->modelClass;
            */
            $className = $this->generateClassName($tableName);

            // ========= ========= ========= ========= ========= ========= ========= ========= ========= |
            //   copy from ...
            $name = $tableName;


            // -------------------------------------------------------------------------------  +|
            $formPath = implode(
                DIRECTORY_SEPARATOR,
                array_filter([
                    ($this->srcDir), // FIXME  临时的 可以更改下 比如从UI选择
                    ucfirst($className)  //. '.html',
                ])
            );

            /** =========      =============================== */
            DynamicActiveRecord::setDbID($this->db);
            DynamicActiveRecord::setTableName($tableName);
            $model = new DynamicActiveRecord();
            $model->loadDefaultValues();
            // $defaults = $model->asArray(); 
            $defaults = $model->getAttributes();
            /** =========      =============================== */

            $files[] = new CodeFile(
                $formPath . '_form.html',
                $this->render('form.php', [
                    'properties' => $this->generateProperties($tableSchema),
                    'labels' => $this->generateLabels($tableSchema),
                    'tableName' => $tableName, //NOTE : 这个比较重要的属性哦 会在视图上用到
                    'defaults' => $defaults,
                    'rules'=>$this->generateRules($tableSchema),
                    'className'=>$className,
                ])
            );

            /*
            $files[] = new CodeFile(
                $formPath . '_table.html',
                $this->render('table.php', [
                    'properties' => $this->generateProperties($tableSchema),
                    'labels' => $this->generateLabels($tableSchema)
                ])
            );
            $files[] = new CodeFile(
                $formPath . '_search.html',
                $this->render('_search.php', [
                    'properties' => $this->generateProperties($tableSchema),
                    'labels' => $this->generateLabels($tableSchema)
                ])
            );
            */
        }
        return $files;
    }

    /**
     * Returns table schema for current model class or false if it is not an active record
     * @return \yii\db\TableSchema|false
     */
    public function getTableSchema($tableName)
    {
        $db = $this->getDbConnection();

        $tableSchema = $db->getTableSchema($tableName);
        /*
        $class = $this->modelClass;
        if (is_subclass_of($class, '\yii\db\BaseActiveRecord')) {
            return $class::getTableSchema();
        }
        */

        return $tableSchema;
    }


    /**
     * Generates code for element-plus form item input
     * @param string $attribute
     * @return string
     */
    // public function generateActiveField($tableName,$attribute)
    public function generateFormItemField($tableName, $attribute, $formModelName = 'ruleForm')
    {
        $tableSchema = $this->getTableSchema($tableName);
        if ($tableSchema === false || !isset($tableSchema->columns[$attribute])) {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $attribute)) {
                // return "\$form->field(\$model, '$attribute')->passwordInput()";
                return "<el-input v-model=\"{$formModelName}.{$attribute}\" type=\"password\" autocomplete=\"off\" />";
            }

            // return "\$form->field(\$model, '$attribute')";
            return "<el-input v-model=\"{$formModelName}.{$attribute}\"  />";
        }
        $column = $tableSchema->columns[$attribute];
        if ($column->phpType === 'boolean') {
            // return "\$form->field(\$model, '$attribute')->checkbox()";
            return "<el-switch v-model=\"{$formModelName}.{$attribute}\"  />";
        }

        if ($column->type === 'text') {
            // return "\$form->field(\$model, '$attribute')->textarea(['rows' => 6])";
            return "<el-input v-model=\"{$formModelName}.{$attribute}\   type=\"textarea\" />";
        }

        if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
            // $input = 'passwordInput';
            return "<el-input v-model=\"{$formModelName}.{$attribute}\" type=\"password\" autocomplete=\"off\" />";
        } else {
            // $input = 'textInput';
            return "<el-input v-model=\"{$formModelName}.{$attribute}\"  />";
        }

        if (is_array($column->enumValues) && count($column->enumValues) > 0) {
            $dropDownOptions = [];
            foreach ($column->enumValues as $enumValue) {
                $dropDownOptions[$enumValue] = Inflector::humanize($enumValue);
            }
            // return "\$form->field(\$model, '$attribute')->dropDownList("
            //     . preg_replace("/\n\s*/", ' ', VarDumper::export($dropDownOptions)).", ['prompt' => ''])";

            $elOptions = [];
            foreach ($dropDownOptions as $optionValue => $optionTitle) {
                $elOptions[] = "<el-option label=\"{$optionTitle}\" value=\"{$optionValue}\" />";
            }
            $elOptionsHtml = implode('', $elOptions);
            return "<el-select v-model=\"{$formModelName}.{$attribute}\"  placeholder=\"please select your {$attribute}\">
                     {$elOptionsHtml}
                     </el-select>";
        }

        // if ($column->phpType !== 'string' || $column->size === null) {
        //     return "\$form->field(\$model, '$attribute')->$input()";
        // }

        // return "\$form->field(\$model, '$attribute')->$input(['maxlength' => true])";
        // TODO: 支持更多的类型 比如 日期｜时间 数字类型 主要依据就是根据字段名称包含的关键字猜测 或者是转化为php类型后可能对应的表单类型
        // Todo: 交互式生成代码 让用户自己选择字段类型 从gii代码生成页面传递过来


        return "<el-input v-model=\"{$formModelName}.{$attribute}\"  />";
    }

    /**
     * Generates validation rules for the specified table.
     * @param \yii\db\TableSchema $table the table schema
     * @return array the generated validation rules
     */
    public function generateRules($table)
    {
        $types = [];
        $lengths = [];
        $rules = [];
        foreach ($table->columns as $column) {
            $rule4column = [];
            if ($column->autoIncrement) {
                continue;
            }
            if (!$column->allowNull && $column->defaultValue === null) {
                $types['required'][] = $column->name;
                // $rules[$column->name][] = 

                $rule4column = [
                    'required' => true,
                    'message' => "{$column->name} is requried",
                    'trigger' => 'blur', // ['blur','change'] ,
                    // todo: 到底是什么事件触发验证需要根据对应的fromInput 类型决定
                ];
            }
            // @see https://github.com/yiminghe/async-validator#type
            switch ($column->type) {
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                case Schema::TYPE_TINYINT:
                    $types['integer'][] = $column->name;
                    $rule4column['type'] = 'integer';
                    break;
                case Schema::TYPE_BOOLEAN:
                    $types['boolean'][] = $column->name;
                    $rule4column['type'] = 'boolean';
                    break;
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                    $types['number'][] = $column->name;

                    $rule4column['type'] = 'number';
                    break;
                case Schema::TYPE_DATE:
                    $rule4column['type'] = 'date';
                    break;
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

                    $rule4column['type'] = 'string';
            }
            if(count($rule4column)>1){
                $rules[$column->name][] = $rule4column;
            }
        }
        foreach ($lengths as $length => $columns) {
            // $rules[] = "[['" . implode("', '", $columns) . "'], 'string', 'max' => $length]";
            // { min: 3, max: 5, message: 'Length should be 3 to 5', trigger: 'blur' },
            foreach($columns as $col){
                $rules[$col][] = [
                    'max'=>$length,
                    'message'=>"max len should be {$length}",
                    'trigger'=>'blur',// FIXME: 这里触发事件待定
                ];
            }
        }

        return $rules ;
        /*
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

        $db = $this->getDbConnection();

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
            $refClassNameResolution = $this->generateClassNameResolution($refClassName);
            unset($refs[0]);
            $attributes = implode("', '", array_keys($refs));
            $targetAttributes = [];
            foreach ($refs as $key => $value) {
                $targetAttributes[] = "'$key' => '$value'";
            }
            $targetAttributes = implode(', ', $targetAttributes);
            $rules[] = "[['$attributes'], 'exist', 'skipOnError' => true, 'targetClass' => $refClassNameResolution, 'targetAttribute' => [$targetAttributes]]";
        }

        return $rules;
        */
    }

    protected $classNames2;

    /**
     * @NOTE copy from giiant ；because some version problem i have to do this way.
     *
     * Generates a class name from the specified table name.
     *
     * @param string $tableName the table name (which may contain schema prefix)
     *
     * @return string the generated class name
     */
    public function generateClassName($tableName, $useSchemaName = null)
    {

        //Yii::trace("Generating class name for '{$tableName}'...", __METHOD__);
        if (isset($this->classNames2[$tableName])) {
            //Yii::trace("Using '{$this->classNames2[$tableName]}' for '{$tableName}' from classNames2.", __METHOD__);
            return $this->classNames2[$tableName];
        }

        if (isset($this->tableNameMap[$tableName])) {
            Yii::trace("Converted '{$tableName}' from tableNameMap.", __METHOD__);

            return $this->classNames2[$tableName] = $this->tableNameMap[$tableName];
        }

        if (($pos = strrpos($tableName, '.')) !== false) {
            $tableName = substr($tableName, $pos + 1);
        }

        $db = $this->getDbConnection();
        $patterns = [];
        $patterns[] = "/^{$this->tablePrefix}(.*?)$/";
        $patterns[] = "/^(.*?){$this->tablePrefix}$/";
        $patterns[] = "/^{$db->tablePrefix}(.*?)$/";
        $patterns[] = "/^(.*?){$db->tablePrefix}$/";

        if (strpos((string)$this->tableName, '*') !== false) {
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
                Yii::trace("Mapping '{$tableName}' to '{$className}' from pattern '{$pattern}'.", __METHOD__);
                break;
            }
        }

        $returnName = Inflector::id2camel($className, '_');
        if ($this->singularEntities) {
            $returnName = Inflector::singularize($returnName);
        }

        Yii::trace("Converted '{$tableName}' to '{$returnName}'.", __METHOD__);

        return $this->classNames2[$tableName] = $returnName;
    }

    /**
     * @inheritdoc
     */
    public function successMessage()
    {


        $output = <<<EOD
<p>The test crud suite  has been generated successfully.</p>
EOD;

        //        $routePath = Inflector::camel2id(StringHelper::basename($this->modelClass));


        $code = <<<EOD
<?php
    // some comment here！
    ......
   
    ......
   
EOD;

        return $output . '<pre>' . highlight_string($code, true) . '</pre>';
    }


    /**
     *
     * Generates the fake data for the specified table.
     *
     * @param \yii\db\TableSchema $table the table schema
     * @param bool $ignorePrimaryKey
     * @return array the generated fake record for table
     * @since 0.0.1
     */
    public function genFakeRecord($table, $ignorePrimaryKey = true)
    {
        $fakeRow = [];
        foreach ($table->columns as $column) {
            /*
            if(true == $ignorePrimaryKey){
                if(in_array($column->name ,  $table->primaryKey)) {
                    continue ;
                }
            }*/
            if ($column->isPrimaryKey) {
                continue;
            }
            $columnPhpType = $column->phpType;
            $fakeRow[$column->name] = GiiantFaker::value(
                $columnPhpType,
                $column->name
            ); //  call_user_func_array(['year\gii\goodmall\helpers\GiiantFaker',$columnPhpType],[$column->name] );
            // $fakeRow[$column->name] =  GiiantFaker::{$columnPhpType};

        }
        return $fakeRow;
    }
}
