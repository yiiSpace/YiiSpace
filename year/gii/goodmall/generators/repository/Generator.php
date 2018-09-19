<?php

namespace year\gii\goodmall\generators\repository;

use year\gii\goodmall\Config;
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
 * This generator will generate repository（interface|implement） code for the specified database table.
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

        $projectHome = Config::getProjectHome();

        if (empty($this->repositoryInterfacePath)) {
            $this->repositoryInterfacePath = implode(DIRECTORY_SEPARATOR, [
                $projectHome,
                'pods',
                '__pod__',
                'domain',
            ]);
        }
        if (empty($this->repositoryImplementPath)) {
            $this->repositoryImplementPath = implode(DIRECTORY_SEPARATOR, [
                $projectHome,
                'pods',
                '__pod__',
                'infra',
                'repo',
                'mysql',
            ]);
        }
    }

    /**
     * @var string
     */
    public $repositoryInterfacePath = '';

    /**
     * @var string
     */
    public $repositoryImplementPath = '';

    /**
     * @var string
     */
    public $repositoryInterfaceType = '';


    /**
     * 获取仓储实现类型的类型
     *
     * 这个目前做成根据 实现包位置 以及所要实现的接口类型来推断
     *
     *
     * @return mixed
     */
    public function getRepositoryImplementType()
    {
        $parts = explode('.', $this->repositoryInterfaceType);
        return end($parts);
    }

    /**
     * @var string
     */
    public $modelType = '';

    /**
     * @var string
     */
    public $searchModelType = '';


    /**
     * @var bool whether to generate a Search Model for this corresponding Model
     */
    public $generateSearchModel = false;


    /**
     * @var null string for the table prefix, which is ignored in generated class name
     */
    public $tablePrefix = null;

    /**
     * 额外导入的包  \s\n 分割
     *
     * 或者原封不动的输出到 go 文件顶部 import部分
     *
     * @var string
     */
    public $extraImports = '';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Goodmall-Model-Repository Generator';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '此生成器针对特定的数据库表 生成 仓储实现 代码';
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

                ['repositoryInterfacePath', 'string', 'message' => '仓储接口所在路径|目录 '],
                [['repositoryInterfacePath',], 'required',],


                [['repositoryInterfacePath', 'repositoryImplementPath'], 'validateDirPath'],


                [['repositoryInterfaceType',], 'string',],
                [['repositoryInterfaceType',], 'required',],
                [['repositoryInterfaceType',], 'validateType',],
                [['repositoryInterfaceType',], 'match', 'pattern' => '/Repo$|Repository$/',
                    'message' => 'Repository class name must be suffixed with "Repo" or "Repository".'],

                [['modelType', 'searchModelType'], 'required',],
                [['modelType', 'searchModelType'], 'match', 'pattern' => '/[\w]+\.[\w]+$/' /*'/^[\w\\\\]*$/'*/, 'message' => '类型类型有误, 形如[pkgLocalName] pkgPath.ModelType'],

            ]
        );
        return $rules;

    }

    /**
     * Validates the namespace.
     *
     * @param string $attribute Namespace variable.
     */
    public function validateNamespace($attribute)
    {
        /*
        $value = $this->$attribute;
        $value = ltrim($value, '\\');
        $path = Yii::getAlias('@' . str_replace('\\', '/', $value), false);
        if ($path === false) {
            $this->addError($attribute, 'Namespace must be associated with an existing directory.');
        }
        */
        // 此处的名空间 指的是goodmall中的 而不是 yii系统中的
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'repositoryInterfacePath' => '仓储接口所在路径|目录 ',
                'repositoryImplementPath' => '仓储接口实现类所在路径|目录 ',
                'repositoryInterfaceType' => '仓储接口类型 ',      // pkgName.XxxRepo
                //  'repositoryImplementType' => '仓储接口实现类型 ', // pkgName.XxxRepo

            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function hints()
    {
        return array_merge(
            parent::hints(),
            [
                'repositoryInterfacePath' => 'Repo 接口路径',
                'repositoryImplementPath' => 'Repo 实现路径',
                'repositoryInterfaceType' => 'Repo 接口类型 带包路径的形式  e.g.,<code>[localPackageName]  github.com/user/project/domain.UserRepo</code>',
                // 'repositoryImplementType' => 'Repo 实现类型 带包名的形式  e.g.,<code>mysql.UserRepo|mongodb.UserRepo</code>',
                'modelType' => 'Repo 对应的模型类型 带包名的形式  e.g.,<code>((localName\s+pkgPath)|(pkgPath/))domain.User|model.User|store.store</code>',
                'searchModelType' => 'Repo 对应的搜索模型类型 带包名的形式  e.g.,<code>[github.com/user/project/]domain.UserSearch|model.UserSearch|store.StoreSearch</code>',
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
            'repo-impl.go.php',
            'repo-interface.go.php',
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
                'rules' => $this->generateRules2($tableSchema),
                'searchModelRules' => $this->generateRules2($tableSchema, true),
                'enum' => $this->getEnum($tableSchema->columns),
            ];


            $params['timestamp'] = $this->generateTimestamp($tableSchema);

            // 生接口文件
            // $repoInterfaceName =
            $repoInterfacePath = implode(DIRECTORY_SEPARATOR, [
                $this->repositoryInterfacePath,
                end(explode('.', $this->repositoryInterfaceType)) . '.go',
            ]);
            $files[] = new CodeFile(
                $repoInterfacePath,
                $this->render('repo-interface.go.php', $params)
            );

            // 接口实现文件
            $repoImplPath = implode(DIRECTORY_SEPARATOR, [
                $this->repositoryImplementPath,
                $this->getRepositoryImplementType() . '.go',
            ]);
            $files[] = new CodeFile(
                $repoImplPath,
                $this->render('repo-impl.go.php', $params)
            );

        }

        return $files;
    }

    /**
     * Generates search conditions
     * @param string $searchModelVar
     * @return array
     */
    public function generateSearchConditions($searchModelVar = 'sm')
    {
        $columns = [];
        $table = $this->getDbConnection()->getTableSchema($this->tableName);

        foreach ($table->columns as $column) {
            $columns[$column->name] = $column->type;
        }

        $likeConditions = [];
        $hashConditions = [];
        foreach ($columns as $column => $type) {
            $searchModelProp = $this->getStructPropNameFromField($column);
            switch ($type) {
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
                    $hashConditions[] = "\"{$column}\" : {$searchModelVar}.{$searchModelProp} ";
                    break;
                default:
                    // $likeKeyword = $this->getClassDbDriverName() === 'pgsql' ? 'ilike' : 'like';
                    // $likeConditions[] = "->andFilterWhere(['{$likeKeyword}', '{$column}', \$this->{$column}])";
                    $likeConditions[] = "\"{$column}\" , {$searchModelVar}.{$searchModelProp} ";;
                    break;
            }
        }

        $conditions = [];
        if (!empty($hashConditions)) {
            /*
            $conditions[] = "\$query->andFilterWhere([\n"
                . str_repeat(' ', 12) . implode("\n" . str_repeat(' ', 12), $hashConditions)
                . "\n" . str_repeat(' ', 8) . "]);\n";
            */
            // $conditions[]  = "FilterCond(Eq{" . implode("," ,$hashConditions) .'}),';
            foreach ($hashConditions as $i => $hashCondition) {
                $conditions[] = "FilterCond(Eq{" . $hashCondition . "}),\n";
            }
        }
        if (!empty($likeConditions)) {
            // $conditions[] = "\$query" . implode("\n" . str_repeat(' ', 12), $likeConditions) . ";\n";

            foreach ($likeConditions as $i => $likeCondition) {
                $conditions[] = "FilterCond(Like{" . $likeCondition . "}),\n";
            }

        }

        return $conditions;
    }

    /**
     * @param string $field
     * @return string
     */
    protected function getStructPropNameFromField($field = '')
    {
        return Inflector::id2camel($field, '_');
    }

    /**
     * @inheritdoc
     */
    public function successMessage()
    {


        $output = <<<EOD
<p>The goodmall crud suite  has been generated successfully.</p>
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
        $goTableColumns = $this->getXormColumns($table->name);
        $properties = [];
        foreach ($table->columns as $column) {
            $columnPhpType = $column->phpType;
            if ($columnPhpType === 'integer') {
                $type = 'int';
            } elseif ($columnPhpType === 'boolean') {
                $type = 'bool';
            } else {
                $type = $columnPhpType;
            }
            $properties[$column->name] = [
                'type' => $type,
                'name' => $column->name,
                'comment' => $column->comment,
                'description' => $goTableColumns[$column->name]['Description'],
            ];
        }

        return $properties;
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
     * 获取表对应的所有列描述
     *
     * 里面主要有
     * - 字段对应的go类型
     * - 列字段描述  ----    这个目前在yii中暂无提供 参考：yii\db\ColumnSchemaBuilder::__toString
     *
     * @param string $table
     * @return mixed
     */
    protected function getXormColumns($table = '')
    {

        $giiEndpoint = Config::goGiiBaseUrl() . "/gii/table/{$table}";// 'http://localhost:1323/gii/project-home';

        $response = file_get_contents($giiEndpoint);
        $columns = Json::decode($response);

        return $columns;
    }

    public function validateDirPath($attribute, $params, $validator)
    {
        if (!is_dir($this->{$attribute})) {
            $this->addError($attribute, ' please check the dir which should must exists： ' . ($this->{$attribute}));
        }
    }

    /**
     * go类型验证
     *
     * TODO 有机会写一个完整的正则来验证
     * 形如：
     * - github.com/user_or_org/project_name/domain.v2.SomeTypeInDomain
     * - beeLogger github.com/beego/bee/logger.SomeTypeInLogger
     *
     * @param $attribute
     * @param $params
     * @param $validator
     */
    public function validateType($attribute, $params, $validator)
    {
        $typ = $this->{$attribute};
        // $pattern = '/^\w+\.\w+$/';
        $pattern = '/\w+\.\w+$/';
        //   preg_match($str2,$str)?true:false;  // preg_match 返回匹配上的次数（由于非贪婪 所以匹配上了就是1 松散等价true）
        //  0 表示匹配上了0次 false表示正则模式有问题 这二者都是false-like
        if (preg_match($pattern, $typ) !== 1) {
            $this->addError($attribute, ' please check the type ： ' . ($this->{$attribute}) . " should like  <pkgName>.<TypeName>");
        }
    }

    /**
     * @param string $qualifiedType
     * @return bool|string
     */
    public function getPackagePath($qualifiedType)
    {
        // 全称限定 full qualified
        return substr($qualifiedType, 0, strrpos($qualifiedType, '.'));
    }

    /**
     * @param  string $qualifiedType
     * @return bool|string
     */
    public function resolveType($qualifiedType)
    {
        $qualifiedType = str_replace(DIRECTORY_SEPARATOR, '/', $qualifiedType);
        $qualifiedType = trim($qualifiedType);

        $type = substr($qualifiedType, strrpos($qualifiedType, '.') + 1);
        // 形如： localName github.com/some-user/some-project/some-domain.SomeType
        $parts = preg_split("/[\s]+/", $qualifiedType);
        if (count($parts) > 1) {
            $type = $parts[0] . '.' . $type;
        } else {
            // FIXME 这里总有一些特殊包命名  如果真不是按照惯例的 那么就干脆手动指定localName 比如强哥的这个包名
            // 不含包别名：   gopkg.in/go-ozzo/ozzo-dbx.v1 | "gopkg.in/yaml.v2"
            $pkgName = substr($qualifiedType, strrpos($qualifiedType, '/') + 1);
            $pkgName = substr($pkgName, 0, strpos($pkgName, '.')); // 第一个dot : ozzo-dbx.v1.SomeType

            $type = $pkgName . '.' . $type;
        }
        return $type;
    }
}
