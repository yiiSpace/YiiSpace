<?php

namespace year\gii\gogen\generators\tags;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

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
 */
class Generator extends \schmunk42\giiant\generators\model\Generator
{

    public function actionHi()
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON ;

        $requestParams = Yii::$app->getRequest()->get() + Yii::$app->getRequest()->post() ;

        // $process = new Process(['ls', '-lsa']);
//        $process = new Process(['dir', ]);
        // On Windows
//        $process = Process::fromShellCommandline('echo "!MESSAGE!"');
//        $process = Process::fromShellCommandline('gomodifytags');
        $process = new Process([
            __DIR__.'/bin/my-collect-structs.exe',
            '-file',
//            $requestParams['path'] ,
           urldecode( $requestParams['path'] ),
        ]);


        try {
            $process->mustRun();

            
            return [
                'from'=>__METHOD__,
                //'structs'=>$process->getOutput(),
            ] ;

        } catch (ProcessFailedException $exception) {
//            echo $exception->getMessage();
            return [
              'error'=> 'true', // $exception->getMessage(),
                'params'=>$requestParams ,
                'msg'=>$exception->getMessage(),
//                'trace'=>$exception->getTraceAsString(),
            ];
        }


    }
    public function actionHi0()
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON ;


        // $process = new Process(['ls', '-lsa']);
//        $process = new Process(['dir', ]);
        // On Windows
//        $process = Process::fromShellCommandline('echo "!MESSAGE!"');
        $process = Process::fromShellCommandline('gomodifytags');
        $process->run();

// executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

//        echo $process->getOutput();

        return [
                'from'=>__METHOD__,
                'out'=>$process->getOutput(),
            ] ;
    }


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
     * @var string
     */
    public $struct = '';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gogen-tags-modify Generator';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'go 文件修改tag';
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
                ['struct', 'string', 'message' => '结构体名称'],
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
                'struct' => '结构体',
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
            $formPath = implode(DIRECTORY_SEPARATOR,
                array_filter([
                    ($this->srcDir), // FIXME  临时的 可以更改下 比如从UI选择
                    ucfirst($className) . '.html',
                ]));
            $files[] = new CodeFile(
                $formPath,
                $this->render('form.php', [
                   'properties'=>$this->generateProperties($tableSchema),
                   'labels'=> $this->generateLabels($tableSchema)
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
