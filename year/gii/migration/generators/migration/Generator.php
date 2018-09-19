<?php

namespace year\gii\migration\generators\migration;

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
                . DIRECTORY_SEPARATOR . 'migrations';
        }
    }

    /**
     * @var string
     */
    public $srcDir;

    /**
     * @var bool
     */
    public $generateMigration = true;


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'migration Generator';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '此生成器针对特定的数据库表 生成 迁移 代码';
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

                ['generateMigration', 'boolean'],


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
                'srcDir' => 'migration项目的src目录路径',
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


            // ========= ========= ========= ========= ========= ========= ========= ========= ========= |
            //   copy from ...
            $name = $tableName;
           //  $className = 'm' . gmdate('ymd_His') . '_create_table_' . $name;
            // gii 生成的文件名基本都是固定的 对于有时间戳 或者随机性文件名  没办法预览
            $className = 'm' . gmdate('ymd_H') . '_create_table_' . $name;
//            $file = Yii::getAlias($this->workingPath . DIRECTORY_SEPARATOR . $className . '.php');

            $templateFile = '@bizley/migration/views/create_migration.php';
            $templateFileUpdate = '@bizley/migration/views/update_migration.php';

            $generator = new \bizley\migration\Generator([
                'db' => $this->getDbConnection(), // $this->db,
                'view' => Yii::$app->getView(),  // $this->view,
                'useTablePrefix' => 0, // $this->useTablePrefix,
                'templateFile' => $templateFile,
                'tableName' => $name,
                'className' => $className,
                'namespace' => null,// $this->migrationNamespace,
                'generalSchema' => true, // $this->generalSchema,
            ]);

            $migrationContent = $generator->generateMigration();
            //  echo '<pre>' . (Html::encode($migrationContent)) . '</pre>';
            // die(__METHOD__);
            //    $params['timestamp'] = $this->generateTimestamp($tableSchema);

            // 生文件
            $migrationPath = implode(DIRECTORY_SEPARATOR, array_filter([
                $this->srcDir,
                ucfirst($className) . '.php',
            ]));
            $files[] = new CodeFile(
                $migrationPath,
                $migrationContent
            // $this->render('model.vue.php', $params)
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
<p>The migration crud suite  has been generated successfully.</p>
<p> 为了能够玩耍起来  你需要配置你的路由文件  src/router.js , you need to add this to your application configuration:</p>
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


}
