<?php

namespace year\gii\models\generators\gomodel;

use year\gii\common\helpers\GiiantFaker;
use year\gii\migration\Config;
use Yii;
use yii\base\NotSupportedException;
use yii\db\Schema;
use yii\db\TableSchema;
use yii\gii\CodeFile;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use schmunk42\giiant\helpers\SaveForm;
use yii\helpers\VarDumper;

/**
 * This generator will generate one or multiple migration for the specified database table.
 *
 * @author yiqing
 *
 * @since 0.0.1
 *
 */
class Generator extends \schmunk42\giiant\generators\model\Generator
{

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        // 设置默认值 此处可以通过读取Yii的配置参数获取 比如 : Yii::$app->params['migration_src_dir'];
        if (empty($this->srcDir)) {
            $this->srcDir = Yii::getAlias('@app/runtime')
                . DIRECTORY_SEPARATOR . 'models';
        }
//        if($this->getDbConnection() != null){
//            $this->dbTableNames = $this->getDbConnection()->getSchema()->getTableNames('',true) ;;
//        }
    }

    /**
     * @var string
     */
    public $srcDir;

    /**
     * @var string
     */
    public $daoDir = '';


    /**
     * @return string[]
     * @throws NotSupportedException
     */
    public function getAllTableNames()
    {
        return $this->getDbConnection()->getSchema()->getTableNames('', true);;
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gii-model Generator';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '此生成器针对特定的数据库表 生成 模型';
    }

    /**
     * @var bool
     */
    public $genTableName = true;

    /**
     * @var bool
     */
    public $handleNullColumn = true;


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
                [['db'], 'validateDb'],
                [['tableName'], 'validateTableName'],


            ]);
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

                ['srcDir', 'string', 'message' => ' src目录路径'],
                ['daoDir', 'string', 'message' => 'dao目录路径'],
                [['srcDir',], 'required', 'message' => '你的migration项目src目录 本程序的路径：' . Yii::$app->basePath],

                [['genTableName'], 'boolean'],
                [['handleNullColumn'], 'boolean'],
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
                'srcDir' => '模型的src目录路径',
                'daoDir' => '模型的DAO目录路径',
                'genTableName' => '是否生成表名称',
                'handleNullColumn' => '处理可空字段',
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
                'daoDir' => 'DAO 生成路径 ',
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
            'model.go.php',
            'dao-mysql.go.php',
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
            //          ##   api测试
            $modelPath = implode(DIRECTORY_SEPARATOR,
                array_filter([
                    ($this->srcDir), // FIXME  临时的 可以更改下 比如从UI选择
                    ucfirst($className) . '.go',
                ]));

            // PHP调用本地exe文件 只能用在开发环境哦 生产可不能开gii
            $giiConsolePath = implode(
                DIRECTORY_SEPARATOR,
                [
                    __DIR__,
                    'bin',
                    'gii-console.exe'
                ]
            );
            // 添加额外参数
            $dbName = '';
            $dns = $db->dsn;
            if (preg_match('/dbname=([A-Za-z_]+\w*)/i', $dns, $match) !== false) {
                $dbName = '-d ' . $match[1];
            } else {
                $dbName = 'no';
            }

            $giiConsolePath .= (" -t {$tableName} $dbName ");


            $params = [
                'tableName' => $tableName,
                'tableSchema' => $tableSchema,
                'labels' => $this->generateLabels($tableSchema),
                'hints' => $this->generateHints($tableSchema),
                'rules' => $this->generateRules($tableSchema),
                'enum' => $this->getEnum($tableSchema->columns),
                'primaryKey' => $tableSchema->primaryKey,

                'properties' => $this->generateProperties($tableSchema),
                'labels' => $this->generateLabels($tableSchema),
                'className' => $className,
                'giiConsolePath' => $giiConsolePath,
                'searchConditions'=>$this->generateSearchConditions($tableSchema),
            ];

            $files[] = new CodeFile(
                $modelPath,
                $this->render('model.go.php', $params)
            );

            // --------------------------------------------------------------------
            //                  ## DAO 生成
            $daoDir = implode(DIRECTORY_SEPARATOR,
                array_filter([
                    ($this->daoDir), // FIXME  临时的 可以更改下 比如从UI选择
                    lcfirst($tableName) . '_dao.go',
                ]));
            $files[] = new CodeFile(
                $daoDir,
                $this->render('dao-mysql.go.php', $params)
            );
            // ---------------------------------------------------------------------
            //                  ## Routes

            $routesDir = implode(DIRECTORY_SEPARATOR,
                array_filter([
                    ($this->daoDir), // FIXME  临时的 可以更改下 比如从UI选择
                    lcfirst($tableName) . '_routes.go',
                ]));
            $files[] = new CodeFile(
                $routesDir,
                $this->render('mux-routes.go.php', $params)
            );

            // ---------------------------------------------------------------------
            //                  ## controller

            $handlerDir = implode(DIRECTORY_SEPARATOR,
                array_filter([
                    ($this->daoDir), // FIXME  临时的 可以更改下 比如从UI选择
                    lcfirst($tableName) . '_handlers.go',
                ]));
            $files[] = new CodeFile(
                $handlerDir,
                $this->render('handler.go.php', $params)
            );

            //.......................................................
            //          ## SearchModel
            $modelSearchPath = implode(DIRECTORY_SEPARATOR,
                array_filter([
                    ($this->srcDir), // FIXME  临时的 可以更改下 比如从UI选择
                    ucfirst($className) . '_search.go',
                ]));

            $files[] = new CodeFile(
                $modelSearchPath,
                $this->render('model_search.go.php', $params)
            );

            // --------------------------------------------------
            //          ## Views
            $viewShowPath = implode(DIRECTORY_SEPARATOR,
                array_filter([
                    ($this->srcDir), // FIXME  临时的 可以更改下 比如从UI选择
                    'show.page.tmpl',
                ]));

            $files[] = new CodeFile(
                $viewShowPath,
                $this->render('view-show.go.php', $params)
            );

        }
        return $files;
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

    /**
     * Generates search conditions
     *
     * // @see LikeConditionBuilder  参考这个类实现  里面有简单过滤输入的内容
     *
     * @param TableSchema $table
     * @return \Closure
     */
    public function generateSearchConditions(TableSchema $table)
    {

        $fn = function()use($table){
            $columns = [];

            foreach ($table->columns as $column) {
                $columns[$column->name] = $column->type;
            }

            $likeConditions = [];
            $hashConditions = [];
            foreach ($columns as $column => $type) {
                $goField = $this->genGoStructField($column);
                switch ($type) {
                    case Schema::TYPE_TINYINT:
                    case Schema::TYPE_SMALLINT:
                    case Schema::TYPE_INTEGER:
                    case Schema::TYPE_BIGINT:
                    case Schema::TYPE_BOOLEAN:
                    case Schema::TYPE_FLOAT:
                    case Schema::TYPE_DOUBLE:
                    case Schema::TYPE_DECIMAL:
                    case Schema::TYPE_MONEY:
                    case Schema::TYPE_DATE:
                    case Schema::TYPE_TIME:
                    case Schema::TYPE_DATETIME:
                    case Schema::TYPE_TIMESTAMP:

                        $hashConditions[] = "\"{$column}\": sm.$goField";
                        break;
                    default:
//                    $likeKeyword = $this->getClassDbDriverName() === 'pgsql' ? 'ilike' : 'like';
//                    $likeConditions[] = "->andFilterWhere(['{$likeKeyword}', '{$column}', \$this->{$column}])";
                        $likeConditions[] = "sq.Like{\"{$column}\": sm.$goField },";
                        break;
                }
            }

            $conditions = [];
            if (!empty($hashConditions)) {
//            $conditions[] = "\$query->andFilterWhere([\n"
//                . str_repeat(' ', 12) . implode("\n" . str_repeat(' ', 12), $hashConditions)
//                . "\n" . str_repeat(' ', 8) . "]);\n";

                $conditions[] = "sq.Eq{" . implode(',', $hashConditions) . "},\n";
            }
            if (!empty($likeConditions)) {
                // $conditions[] = "\$query" . implode("\n" . str_repeat(' ', 12), $likeConditions) . ";\n";
                $conditions[] = implode("\n", $likeConditions) . "\n";
            }

            return $conditions;
        };

        return $fn ;

    }

    public function genGoStructField($dbField)
    {
        $prop = Inflector::id2camel($dbField, '_');
        return $prop;
    }

    /**
     * @param TableSchema $tableSchema
     * @param $columnName
     * @return \yii\db\ColumnSchema
     */
    public function getColumnSchema(TableSchema $tableSchema, $columnName)
    {
        return $tableSchema->getColumn($columnName);
    }

    /**
     * @TODO 提取出来干扰主逻辑
     * @param string $tableName
     * @return string
     */
    public function getGiiConsolePath($tableName)
    {
        $db = $this->getDbConnection();
        $dbName = '';
        $dns = $db->dsn;
        if (preg_match('/dbname=([A-Za-z_]+\w*)/i', $dns, $match) !== false) {
            $dbName = '-d ' . $match[1];
        } else {
            $dbName = 'no';
        }

        $giiConsolePath .= (" -t {$tableName} $dbName ");
        return $giiConsolePath;
    }

    /**
     * @inheritdoc
     */
    public function successMessage()
    {

        $routes = $this->render('mux-routes.go.php', [

        ]);


        $output = <<<EOD
<p>The test crud suite  has been generated successfully.</p>
EOD;

        $routePath = Inflector::camel2id(StringHelper::basename($this->modelClass));


        $code = <<<EOD
<?php
    // some comment here！
    ......
         {$routes}
    ......
   
EOD;

        return $output . '<pre>' . highlight_string($code, true) . '</pre>';
    }

    /**
     * 执行win下的命令行程序根php配置文件有关 或者可能跟apache权限有关 请自行查找相关细节
     *
     * @param string $giiConsolePath
     * @return array|mixed
     */
    public function columnsMetaData($giiConsolePath = '')
    {
        // system($giiConsolePath, $info);
        // echo $info;
        //echo $giiConsolePath ;
        //exec($giiConsolePath, $output, $return_val);
        //print_r($output);
        //print_r($return_val) ;
        //
        //$out = system($giiConsolePath,$return_status) ;
        //if($return_status == 0){
        //  // $jsonData =  \yii\helpers\Json::decode( $out ) ;
        //  // print_r($jsonData) ;
        //    echo 'jjjj' ;
        //
        //    echo  gettype(json_decode($out)) ;
        //}else{
        //    echo 'failed' ;
        //}

        ob_start();
        passthru($giiConsolePath, $exitCode);
        $cmdOut = ob_get_contents();
        ob_end_clean(); //Use this instead of ob_flush()
        if ($exitCode == 0) {
            // echo  gettype($cmdOut) ;
            $j = json_decode($cmdOut, true);
            // todo try catch 包裹下 返回的也可能不是合法json
            return ($j);
        } else {
            return [];
        }
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
            );//  call_user_func_array(['year\gii\goodmall\helpers\GiiantFaker',$columnPhpType],[$column->name] );
            // $fakeRow[$column->name] =  GiiantFaker::{$columnPhpType};

        }
        return $fakeRow;
    }

}
