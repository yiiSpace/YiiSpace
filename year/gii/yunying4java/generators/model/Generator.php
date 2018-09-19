<?php

namespace year\gii\yunying4java\generators\model;

use year\gii\yunying4java\Config;
use Yii;
use yii\base\NotSupportedException;
use yii\db\Schema;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use schmunk42\giiant\helpers\SaveForm;
use yii\helpers\VarDumper;

/**
 * This generator will generate one or multiple model struct for the specified database table.
 *
 * @author yiqing
 *
 * @since 0.0.1
 *
 * @todo 支持模型验证规则的生成！
 */
class Generator extends \schmunk42\giiant\generators\model\Generator
{

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if (empty($this->srcDir)) {
            /*
            $this->srcDir = dirname(Yii::$app->basePath)
                . DIRECTORY_SEPARATOR . 'frontend-yunying'
                . DIRECTORY_SEPARATOR . 'src';
            */
            $this->srcDir = sys_get_temp_dir() ;
        }
    }

    /**
     * @var string
     */
    public $srcDir;

    /**
     * @var bool
     */
    public $generateModelDir = false;

    /**
     * @var bool whether to generate a Search Model for this corresponding Model
     */
    public $generateSearchModel = false;


    /**
     * @var null string for the table prefix, which is ignored in generated class name
     */
    public $tablePrefix = null;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'yunying4java-Model Generator';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '此生成器针对特定的数据库表 生成 模型 代码';
        // return 'This generator generates an ActiveRecord class and base class for the specified database table.';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {


        $rules = parent::rules();

        /*
        // 重置下 required 验证规则
        $requiredRulesIndexes = [] ;
        foreach ($rules as $idx=>$rule){
            $validator = $rule[1] ;
            if($validator == 'required'){
                $requiredRulesIndexes[] = $idx ;
            }
        }
        if(!empty($requiredRulesIndexes)){

            foreach ($requiredRulesIndexes as $index){
                echo $index , '<br/>' ;
                unset($rules[$idx]) ;
            }
        }
        */
        $requiredRule = function ($rule) {
            return $rule[1] != 'required';
        };
        $rules = array_filter($rules, $requiredRule);

        $rules = array_merge(
            $rules,
            [
                [['template'], 'required', 'message' => 'A code template must be selected.'],


                [['db', 'tableName',], 'required'],

                [['tablePrefix'], 'safe'],

                ['srcDir', 'string', 'message' => 'yunying 项目的 src目录路径'],
                [['srcDir',], 'required', 'message' => '你的yunying项目src目录 本程序的路径：' . Yii::$app->basePath],

                ['generateModelDir', 'boolean'],


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
                'srcDir' => 'yunying项目的src目录路径',
                'generateSearchModel' => '是否生成搜索模型',
                'generateModelDir' => '生成模型目录',
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
     * Validates the [[modelClass]] attribute.
     */
    public function validateModelClass()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function requiredTemplates()
    {
        return [ /*'models/model.js.php',*/
            'model.java.php',
             //  'model-search.go.php',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generate()
    {

        $files = [];
        $db = $this->getDbConnection();

        foreach ($this->getTableNames() as $tableName) {

            $tableSchema = $db->getTableSchema($tableName);
            $className = php_sapi_name() === 'cli'
                ? $this->generateClassName($tableName)
                : $this->modelClass;

            $queryClassName = ($this->generateQuery) ? $this->generateQueryClassName($className) : false;

            $params = [
                'tableName' => $tableName,
                'className' => $className,
                'queryClassName' => $queryClassName,
                'tableSchema' => $tableSchema,
                'properties' => $this->generateProperties($tableSchema),

                'labels' => $this->generateLabels($tableSchema),
                'hints' => $this->generateHints($tableSchema),
                 'rules' => $this->generateRules($tableSchema),
                // 'searchModelRules' => $this->generateRules2($tableSchema, true),
                'enum' => $this->getEnum($tableSchema->columns),
            ];


          //    $params['timestamp'] = $this->generateTimestamp($tableSchema);

            $modelDir = 'models';
            if(! $this->generateModelDir){
                $modelDir = '' ;
            }
            // 生model文件
            $modelPath = implode(DIRECTORY_SEPARATOR, array_filter([
                $this->srcDir,
                $modelDir,
                ucfirst($className) . '.java',
            ] ) );
            $files[] = new CodeFile(
                $modelPath,
                $this->render('model.java.php', $params)
            );

            // 搜索模型文件
            /*
            $modelPath = implode(DIRECTORY_SEPARATOR, [
                $this->srcDir,
                'domain',
                ucfirst($className) . 'Search.go',
            ]);
            $files[] = new CodeFile(
                $modelPath,
                $this->render('model-search.go.php', $params)
            );
            */
            /*
            $modelClassFile = Yii::getAlias('@' . str_replace('\\', '/', $this->ns)) . '/' . $className . '.php';
            if ($this->generateModelClass || !is_file($modelClassFile)) {
                $files[] = new CodeFile(
                    $modelClassFile,
                    $this->render('model-extended.php', $params)
                );
            }
              */
            /*
            if ($queryClassName) {
                $queryClassFile = Yii::getAlias(
                        '@'.str_replace('\\', '/', $this->queryNs)
                    ).'/'.$queryClassName.'.php';
                if ($this->generateModelClass || !is_file($queryClassFile)) {
                    $params = [
                        'className' => $queryClassName,
                        'modelClassName' => $className,
                    ];
                    $files[] = new CodeFile(
                        $queryClassFile,
                        $this->render('query.php', $params)
                    );
                }
            }
            */

            /*
             * create gii/[name]GiiantModel.json with actual form data

            $suffix = str_replace(' ', '', $this->getName());
            $formDataDir = Yii::getAlias('@'.str_replace('\\', '/', $this->ns));
            $formDataFile = StringHelper::dirname($formDataDir)
                    .'/gii'
                    .'/'.$tableName.$suffix.'.json';

            $formData = json_encode(SaveForm::getFormAttributesValues($this, $this->formAttributes()));
            $files[] = new CodeFile($formDataFile, $formData);
             */
        }

        return $files;
    }

    /**
     * @inheritdoc
     */
    public function successMessage()
    {


        $output = <<<EOD
<p>The yunying crud suite  has been generated successfully.</p>
<p> 为了能够玩耍起来  你需要配置你的路由文件  src/router.js , you need to add this to your application configuration:</p>
EOD;

        $routePath = Inflector::camel2id(StringHelper::basename($this->modelClass));


        $code = <<<EOD
<?php
    // src/router.js
    ......
   
    ......
   
EOD;

        return $output . '<pre>' . highlight_string($code, true) . '</pre>';
    }

    /**
     * Generates the properties for the specified table.
     *
     * TODO 取对应的go类型 需要通过api访问来做 暂时先用php类型 大部分相同！
     *
     * @param \yii\db\TableSchema $table the table schema
     * @return array the generated properties (property => type)
     * @since 2.0.6
     */
    protected function generateProperties($table)
    {

        return parent::generateProperties($table);
    }

    public function generateRules($table)
    {
        $types = [];
        $lengths = [];
        $columnConstraints = [] ;
        foreach ($table->columns as $column) {
            if ($column->autoIncrement) {
                continue;
            }
            if (!$column->allowNull && $column->defaultValue === null) {
               // $types['required'][] = $column->name;
                $columnConstraints[$column->name][] = '@NotEmpty ';
            }
            switch ($column->type) {
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                case Schema::TYPE_TINYINT:
                    // $types['integer'][] = $column->name;
                    break;
                case Schema::TYPE_BOOLEAN:
                   // $types['boolean'][] = $column->name;
                    break;
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                   //  $types['number'][] = $column->name;
                    break;
                case Schema::TYPE_DATE:
                case Schema::TYPE_TIME:
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                    // $types['safe'][] = $column->name;
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
            unset($refs[0]);
            $attributes = implode("', '", array_keys($refs));
            $targetAttributes = [];
            foreach ($refs as $key => $value) {
                $targetAttributes[] = "'$key' => '$value'";
            }
            $targetAttributes = implode(', ', $targetAttributes);
            $rules[] = "[['$attributes'], 'exist', 'skipOnError' => true, 'targetClass' => $refClassName::className(), 'targetAttribute' => [$targetAttributes]]";
        }

        return $columnConstraints;
    }

    /**
     * Generates validation rules for the specified table.
     *
     * @see https://github.com/go-ozzo/ozzo-validation
     * 根据强哥的这个验证库来做的
     *
     * @param \yii\db\TableSchema $table the table schema
     * @param bool $forSearchModel 是否用于搜索模型
     * @return array the generated validation rules
     */
    public function generateRules2($table, $forSearchModel = false)
    {
        /**
         * @var  $columnTypes
         * return validation.ValidateStruct(&a,
         *     // Street cannot be empty, and the length must between 5 and 50
         *     validation.Field(&a.Street, validation.Required, validation.Length(5, 50)),
         */
        $columnTypes = [];  // &a.Street, validation.Required, validation.Length(5, 50)
        $lengths = [];
        foreach ($table->columns as $column) {
            if ($column->autoIncrement) {
                continue;
            }
            if (!$forSearchModel && !$column->allowNull && $column->defaultValue === null) {
                // $types['required'][] = $column->name;
                $columnTypes[$column->name][] = "validation.Required";
            }
            // NOTE 类型验证因为go语言是强类型所以在跟上就断绝了类型错误问题 此处就可以略过了！
            switch ($column->type) {
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                    //  $types['integer'][] = $column->name;
                    break;
                case Schema::TYPE_BOOLEAN:
                    //  $types['boolean'][] = $column->name;
                    break;
                case Schema::TYPE_FLOAT:
                case 'double': // Schema::TYPE_DOUBLE, which is available since Yii 2.0.3
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                    // $types['number'][] = $column->name;
                    break;
                case Schema::TYPE_DATE:
                case Schema::TYPE_TIME:
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                    // $types['safe'][] = $column->name;
                    break;
                default: // strings
                    if ($column->size > 0) {
                        $lengths[$column->size][] = $column->name;
                    } else {
                        // $types['string'][] = $column->name;
                    }
            }
        }
        $rules = [];
        $driverName = $this->getDbDriverName();
        /*
        foreach ($types as $type => $columns) {
            if ($driverName === 'pgsql' && $type === 'integer') {
                $rules[] = "[['" . implode("', '", $columns) . "'], 'default', 'value' => null]";
            }
            $rules[] = "[['" . implode("', '", $columns) . "'], '$type']";
        }
        */

        foreach ($lengths as $length => $columns) {
            //  $rules[] = "[['" . implode("', '", $columns) . "'], 'string', 'max' => $length]";
            foreach ($columns as $col) {

                $columnTypes[$col][] = "validation.Length(0, {$length})"; //validation.Length(5, 100), // length between 5 and 100
            }
        }

        foreach ($columnTypes as $column => $types) {
            $goFieldName = Inflector::id2camel($column, '_');
            // sample :// Street cannot be empty, and the length must between 5 and 50
            // validation.Field(&a.Street, validation.Required, validation.Length(5, 50)),
            $rules[] = sprintf("validation.Field(%s,%s)",
                '&m.' . $goFieldName,  // 模型字段名
                implode(', ', $types)
            );
        }

        $db = $this->getDbConnection();

        // Unique indexes rules
        // TODO 暂时不考虑 这种逻辑目前go-ozzo/ozzo-validation 没有支持 需要用验证函数来实现 依赖模型对应的Repository来做查询
        try {
            $uniqueIndexes = array_merge($db->getSchema()->findUniqueIndexes($table), [$table->primaryKey]);
            $uniqueIndexes = array_unique($uniqueIndexes, SORT_REGULAR);
            foreach ($uniqueIndexes as $uniqueColumns) {
                // Avoid validating auto incremental columns
                if (!$this->isColumnAutoIncremental($table, $uniqueColumns)) {
                    $attributesCount = count($uniqueColumns);

                    if ($attributesCount === 1) {
                        //  $rules[] = "[['" . $uniqueColumns[0] . "'], 'unique']";
                    } elseif ($attributesCount > 1) {
                        $columnsList = implode("', '", $uniqueColumns);
                        // $rules[] = "[['$columnsList'], 'unique', 'targetAttribute' => ['$columnsList']]";
                    }
                }
            }
        } catch (NotSupportedException $e) {
            // doesn't support unique indexes information...do nothing
        }
        // Exist rules for foreign keys


        return $rules;
    }


}
