<?php

namespace year\gii\nodetest\generators\fixtures;

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
                . DIRECTORY_SEPARATOR . 'node-fixtures';
        }
    }

    /**
     * @var string
     */
    public $srcDir;

    /**
     * 如果有多个的话 不妨多几个
     * - apiGetPath
     * - apiPutPath
     * - apiListPath
     * - apiDeletePath
     *
     * @var string route path for api
     */
    public $apiPath;

    /**
     * @var bool
     */
    public $generateTest = true;


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'nodetest Generator';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '此生成器针对特定的数据库表 生成 测试 样例数据';
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

                ['srcDir', 'string', 'message' => 'migration 项目的 src目录路径'],
                [['srcDir',], 'required', 'message' => '你的migration项目src目录 本程序的路径：' . Yii::$app->basePath],

                ['generateTest', 'boolean'],


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
                'srcDir' => 'fixtures的src目录路径',
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
            'api-crud-test.php',
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


//            $fakeRecord = $this->genFakeRecord($tableSchema) ;
            $fakeData = [
                'createData' => $this->genFakeRecord($tableSchema),
                'updateData' => $this->genFakeRecord($tableSchema),
            ];
//            $migrationContent =  var_export($fakeData, true);

            // 要是闲输出不好看 需要用Zend 库中关于json的处理了！
//            $migrationContent =  Json::encode($fakeData);
            $fixturesContent = json_encode($fakeData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $fixturesContent = <<<DATA
'ues strict';

module.exports =  
    $fixturesContent
 
DATA;


            //  echo '<pre>' . (Html::encode($migrationContent)) . '</pre>';
            // die(__METHOD__);
            //    $params['timestamp'] = $this->generateTimestamp($tableSchema);

            // 生文件
            $fixturesPath = implode(DIRECTORY_SEPARATOR, array_filter([
                $this->srcDir,
                ucfirst($className) . '.js',
            ]));
            $files[] = new CodeFile(
                $fixturesPath,
                $fixturesContent
            // $this->render('model.vue.php', $params)
            );
            // -------------------------------------------------------------------------------  +|
            //          ##   api测试
            $crudTestPath = implode(DIRECTORY_SEPARATOR,
                array_filter([
                    dirname($this->srcDir), // FIXME  临时的 可以更改下 比如从UI选择
                    ucfirst($className) . '.test.js',
                ]));
            $files[] = new CodeFile(
                $crudTestPath,

             $this->render('api-crud-test.php', [
                 'fixtureName'=>ucfirst($className),
             ])
            );
        }
        return $files;
    }

    /**
     * @inheritdoc
     */
    public function successMessage()
    {


        $output = <<<EOD
<p>The test crud suite  has been generated successfully.</p>
EOD;

        $routePath = Inflector::camel2id(StringHelper::basename($this->modelClass));


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
            );//  call_user_func_array(['year\gii\goodmall\helpers\GiiantFaker',$columnPhpType],[$column->name] );
            // $fakeRow[$column->name] =  GiiantFaker::{$columnPhpType};

        }
        return $fakeRow;
    }

}
