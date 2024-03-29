<?php

namespace year\gii\form\generators\form;

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
 *  todo: should extends yii gii Generator!
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
        return 'gii-html-form Generator';
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
            'table.php',
            '_search.php',
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
            $formPath = implode(DIRECTORY_SEPARATOR,
                array_filter([
                    ($this->srcDir), // FIXME  临时的 可以更改下 比如从UI选择
                    ucfirst($className)  //. '.html',
                ]));
            $files[] = new CodeFile(
                $formPath . '_form.html',
                $this->render('form.php', [
                    'properties' => $this->generateProperties($tableSchema),
                    'labels' => $this->generateLabels($tableSchema)
                ])
            );

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

            // 动态渲染crud 应该有个变量开关
            /* ===========================================================================
             begin crud
            */
            $oldApp = Yii::$app;
            $callback = function (\yii\console\Application $consoleApp) use ($oldApp) {

                // use current connection to DB
                \Yii::$app->set('db', $oldApp->db);
                $db = \Yii::$app->getDb();
                $cmd = $db->createCommand('SHOW DATABASES');
                $dbs = $cmd->queryColumn();
                \Yii::debug(implode(',', $dbs), 'year-gii-form');

                $dbMan = $oldApp->get('dbMan');
                $dbMan->bootstrap($consoleApp);
//                $componentDefinitions = $consoleApp->getComponents(true);
//
//            \Yii::error( print_r($componentDefinitions,true),'console');
//
            };

//        php yii gii/model --tableName=page_resource --modelClass=PageResource --ns="backend\models" --queryClass=PageResource --queryNs="backend\models\query"

            $dbId = $this->db; // DbMan::getDbId('tpshop');
            $table = $tableName; // 'tp_users';

            DynamicActiveRecord::setDbID($dbId);
            DynamicActiveRecord::setTableName($tableName);

            // 这里是crud 生成动作
            $result = ConsoleAppHelper::runAction('gii/crud', [
                'controllerClass' => DynamicController::class,
                'modelClass' => DynamicActiveRecord::class,
                'viewPath' => "@backend/runtime/dynamic/views/{$dbId}/{$table}",

            ], $callback);

            DynamicController::$dbID = $dbId;
            DynamicController::$tableName = $table;
//          return \Yii::$app->runAction('dynamic/index',[]);
//            return \Yii::$app->runAction('dynamic/create',[]);
            $crudBasePath = Yii::getAlias('@backend/runtime/_tmp_gii_form_gen/' . $dbId . '/' . $this->tableName . '_');
            $files[] = new CodeFile(
                $crudBasePath . 'create.html',
                \Yii::$app->runAction('dynamic/create', [])
            );
            $files[] = new CodeFile(
                $crudBasePath . 'index.html',
                \Yii::$app->runAction('dynamic/index', [])
            );
// $files[] = new CodeFile(
//                $crudBasePath.'update.html',
//                \Yii::$app->runAction('dynamic/update',[])
//            );
            // 查看视图是需要有记录才行的
            $randomDataModel = DynamicActiveRecord::getRandom();

            if (!empty($randomDataModel)) {
                $pks = $randomDataModel->getPrimaryKey();
                $actionParams = [] ;
                if(is_array($pks)){
                    $actionParams = $pks ;
                }elseif (is_int($pks)){
                    $actionParams['id']= $pks ;
                }else{
                    continue ;
                }
//                if(count($pks) === 1){
//                    $actionParams['id']= $pks ;
//                }else if(count($pks) >1){
//                    $actionParams = $pks ;
//                }else{
//                    // TODO 无主键么！
//                    continue ;
//                }
//                dump($actionParams) ; exit(0);
                $files[] = new CodeFile(
                    $crudBasePath . 'view.html',
                    \Yii::$app->runAction('dynamic/view', $actionParams)
                );

            }
//            dump($randomDataModel->getPrimaryKey()) ; exit(0);

            /*
            end crud
            ======================================================================*/

        }
        return $files;
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
            );//  call_user_func_array(['year\gii\goodmall\helpers\GiiantFaker',$columnPhpType],[$column->name] );
            // $fakeRow[$column->name] =  GiiantFaker::{$columnPhpType};

        }
        return $fakeRow;
    }

}
