<?php

namespace year\gii\migration\generators\migration;

use api\base\Application;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use year\gii\migration\Config;
use year\migration\GeneratorTrait;
use Yii;
use yii\base\NotSupportedException;
use yii\db\Connection;
use yii\db\Schema;
use yii\di\Instance;
use yii\gii\CodeFile;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use schmunk42\giiant\helpers\SaveForm;
use yii\helpers\VarDumper;
use yii\web\View;

/**
 * This generator will generate one or multiple migration for the specified database table.
 *
 * NOTE 真正的生成文件在Generator::save方法上 或者通过 url 到底是生成还是预览 来决策 总之我们需要到底执行的是哪个动作
 *
 * @author yiqing
 *
 * @since 0.0.1
 *
 */
//class Generator extends \schmunk42\giiant\generators\model\Generator
class Generator  extends \yii\gii\generators\model\Generator
{


    const SESSION_MAPPING_KEY = 'sess_migration_mapping';

    /**
     * @var null string for the table prefix, which is ignored in generated class name
     */
    public $tablePrefix = null;

    /**
     * @param CodeFile[] $files
     * @param array $answers
     * @param string $results
     * @return bool
     * @throws \yii\base\InvalidConfigException
     *
     * TODO save完成 删除session哦
     */
    public function save($files, $answers, &$results)
    {
        // session中的映射
        $session = \Yii::$app->session;
        $mapping = $session->get(self::SESSION_MAPPING_KEY);
        // var_dump($mapping) ;
        // var_dump(get_object_vars($this)) ;
        // die(__METHOD__) ;
        //  return parent::save($files, $answers, $results);

        $lines = ['Generating code using template "' . $this->getTemplatePath() . '"...'];
        $hasError = false;
        foreach ($files as $file) {
            $relativePath = $file->getRelativePath();
            if (isset($answers[$file->id]) && !empty($answers[$file->id]) && $file->operation !== CodeFile::OP_SKIP) {
                // -----------------------
                // 修改的地方 字符串替换即可
                 foreach ($mapping as $fakePath => $realPath){
                     if (strpos($file->path, $fakePath) !== FALSE)
                     {
                        $lines[] = '成功一个了  ！';
                        // die('hhahhah');
                         $file->path = str_replace($fakePath,$realPath,$file->path) ;
                         $file->content = str_replace($fakePath,$realPath,$file->content) ;
                         $relativePath = $file->path ;

                         self::$generateResult = "file gen ：$relativePath  " .PHP_EOL ;
                     }
                     else
                     {
                         $lines[] =   'Not found. ya';
                     }
                 }

                // ----------------------

                $error = $file->save();
                if (is_string($error)) {
                    $hasError = true;
                    $lines[] = "generating $relativePath\n<span class=\"error\">$error</span>";
                } else {
                    $lines[] = $file->operation === CodeFile::OP_CREATE ? " generated $relativePath" : " overwrote $relativePath";
                }
            } else {
                $lines[] = "   skipped $relativePath";
            }
        }
        $lines[] = "done!\n";
        $results = implode("\n", $lines);

        // 移除session变量
        unset($session[self::SESSION_MAPPING_KEY]);

        return !$hasError;
    }

    protected static $generateResult = '';

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
    public $generateMigration;


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
        return '此生成器针对特定的数据库表 生成 迁移 代码 (注意 未知原因导致css错乱 生成的代码需要在控制台的response部分查看 而且有时间限制😯)';
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
                'generateMigration' => '是否生成迁移文件',
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
     * TODO: 由于组件升级导致出现bug啦 ！
     * 
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

            /**
             * TODO 使用进程执行bizley/migration 扩展 https://github.com/symfony/symfony/blob/master/src/Symfony/Component/Process/Process.php
             *
             *
             */

            // ========= ========= ========= ========= ========= ========= ========= ========= ========= |
            //   copy from ...
            $name = $tableName;

            // $className = 'm' . gmdate('ymd_His') . '_create_table_' . $name;
            // FIXME gii 生成的文件名基本都是固定的 对于有时间戳 或者随机性文件名  没办法预览
            $className = 'm' . gmdate('ymd_H') . '_create_table_' . $name;
            // $file = Yii::getAlias($this->workingPath . DIRECTORY_SEPARATOR . $className . '.php');
            $realClassName = 'm' . gmdate('ymd_His') . '_create_table_' . $name;

            // 在session中做映射
            $session = \Yii::$app->session;
            $session->set(self::SESSION_MAPPING_KEY, [
                $className => $realClassName,
            ]);


            // 这两个新类没有用到
            $templateFile = '@bizley/migration/views/create_migration.php';
            $templateFileUpdate = '@bizley/migration/views/update_migration.php';

            // 新版的bizley_Generator 比较复杂
            // FIXME: update to the new version .
//            $generator = new \bizley\migration\Generator([
//                'db' => $this->getDbConnection(), // $this->db,
//                'view' => Yii::$app->getView(),  // $this->view,
//                'useTablePrefix' => 0, // $this->useTablePrefix,
//                'templateFile' => $templateFile,
//                'tableName' => $name,
//                'className' => $className,
//                'namespace' => null,// $this->migrationNamespace,
//                'generalSchema' => true, // $this->generalSchema,
//            ]);
//
//            $migrationContent = $generator->generateMigration();
            $generatorWrapper = new GeneratorWrapper($this->getDbConnection());
//            $generatorWrapper->
            $generator = $generatorWrapper->getGenerator();
            $migrationContent = $generator->generateForTable(
                $name,
                $className,[],false,'',null
            );
            //  echo '<pre>' . (Html::encode($migrationContent)) . '</pre>';
            // die(__METHOD__);
            //    $params['timestamp'] = $this->generateTimestamp($tableSchema);

            // 生文件
            $migrationPath = implode(DIRECTORY_SEPARATOR, array_filter([
                $this->srcDir,
                //  ucfirst($className) . '.php',
                ($className) . '.php',
            ]));
            $files[] = new CodeFile(
                $migrationPath,
                $migrationContent
            );

            // 先生成文件然后再删掉
            Yii::$app->on(Application::EVENT_AFTER_ACTION, function () use ($migrationPath) {
                if (file_exists($migrationPath)) {
                    usleep(1000);
                    unlink($migrationPath);
                }

            });
            if ($this->generateMigration) {
                // $this->genMigrationFile($tableName, dirname($migrationPath));
            }

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

        //  $routePath = Inflector::camel2id(StringHelper::basename($this->modelClass));

        $genResult = self::$generateResult;

        $code = <<<EOD
<?php
    // some comment here！
    ......
        {$genResult}
    ......
   
EOD;

        return $output . '<pre>' . highlight_string($code, true) . '</pre>';
    }

    /**
     * @param string $table
     * @param string $migrationPath
     * @return bool
     */
    protected function genMigrationFile($table, $migrationPath = '')
    {

        $yiiPath = \Yii::getAlias('@app');
        $yiiPath = dirname($yiiPath) . DIRECTORY_SEPARATOR . 'yii';

        $runtimeDir = \Yii::getAlias('@runtime/migrations');

        $migrationPathOption = empty($migrationPath) ? '' : sprintf("--migrationPath=%s", $migrationPath);

        $process = new Process([
            'yii',
            'migration/create',
//            'user',
//            '--migrationPath=@runtime/temp',
            $table,
            $migrationPathOption,
        ],
            dirname($yiiPath));
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // TODO 进程输出有用不？
        // echo 'hi:', $process->getOutput();
        self::$generateResult = $process->getOutput();

        return true;
    }


}

class GeneratorWrapper
{
    use GeneratorTrait;

    /**
     * @var null|yii\web\View
     */
    public $view = null ;

    public function __construct(
        yii\db\Connection $db,
        yii\web\View $view = null
    ) {
        $this->db = Instance::ensure($this->db, Connection::class);
        if ($view === null) {
            $this->view = Yii::$app->getView();
        }

    }



}
