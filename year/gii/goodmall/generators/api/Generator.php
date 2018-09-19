<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace year\gii\goodmall\generators\api;

use schmunk42\giiant\helpers\GiiantFaker;
use year\gii\goodmall\Config;
use year\gii\goodmall\utils\QualifiedTypeValidator;
use Yii;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\db\Schema;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;
use yii\web\Application;
use yii\web\Controller;

/**
 * Generates api CRUD
 *
 * api-controller path : goodmall/goodmall/pods/{podID}/adapters/api/gin/controller
 *
 * @property array $columnNames Model column names. This property is read-only.
 * @property string $controllerID The controller ID (without the module ID prefix). This property is
 * read-only.
 * @property array $searchAttributes Searchable attributes. This property is read-only.
 * @property bool|\yii\db\TableSchema $tableSchema This property is read-only.
 * @property string $viewPath The controller view path. This property is read-only.
 *
 * @author yiqing <yiqing_95@qq.com>
 * @since 0.0.1
 */
class Generator extends \yii\gii\Generator
{


    /**
     * @var string
     */
    public $podPath ;


    /**
     * @var string
     */
    public $podId ;
    /**
     * @var string name of interactor
     */
    public $controllerType ;

    /**
     * @var string
     */
    public $interactorType ;


    /**
     * @var string
     */
    public $modelType  ;

    /**
     * @var string
     */
    public $searchModelType  ;


    /**
     * @var string
     */
    public $tableName;
    /**
     * @inheritdoc
     */
    public function autoCompleteData()
    {
        $db = $this->getDbConnection();
        if ($db !== null) {
            return [
                'tableName' => function () use ($db) {
                    return $db->getSchema()->getTableNames();
                },
            ];
        } else {
            return [];
        }
    }


    public $db = 'db';

    /**
     * @return null|object|\yii\db\Connection
     * @throws \yii\base\InvalidConfigException
     */
    protected function getDbConnection()
    {
        return Yii::$app->get($this->db, false);
    }

    public function init()
    {
        parent::init();

        if(empty($this->podPath)){
        //   $this->podPath = Config::getProjectHome().DIRECTORY_SEPARATOR.'pods'.DIRECTORY_SEPARATOR.'__your_pod_id__' ;
            $this->podPath = implode(DIRECTORY_SEPARATOR ,[
                Config::getProjectHome(),
                'pods',
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Goodmall-API-Handler Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator generates a controller  that implement CRUD (Create, Read, Update, Delete)
            operations for the specified data model.';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['controllerType' ], 'filter', 'filter' => 'trim'],
            [['controllerType'], 'required'],

            [['podId' ], 'filter', 'filter' => 'trim'],
            [['podId'], 'required'],

            [['podPath' ], 'filter', 'filter' => 'trim'],

            [['interactorType' ], 'filter', 'filter' => 'trim'],
            [['interactorType'], 'required'],
            [['interactorType'], QualifiedTypeValidator::className(),],

            [['modelType' ], 'filter', 'filter' => 'trim'],
            [['modelType'], 'required'],
            [['modelType'], QualifiedTypeValidator::className(),],

            [['searchModelType' ], 'filter', 'filter' => 'trim'],
            [['searchModelType'], 'required'],
            [['searchModelType'], QualifiedTypeValidator::className(),],

            [['db', 'tableName',], 'filter', 'filter' => 'trim'],
            [['tableName'], 'match', 'pattern' => '/^([\w ]+\.)?([\w\* ]+)$/', 'message' => 'Only word characters, and optionally spaces, an asterisk and/or a dot are allowed.'],
            [['tableName'], 'validateTableName', ],
            // [['podPath'], 'required'],
           // [['podPath'], 'validatePodPath'],

//            [['interactorName' ], 'filter', 'filter' => 'trim'],
           // [['interactorName'], 'required'],


        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
//            'modelClass' => 'Model Class',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'podPath' => 'This is the pod home dir for your specified pod . e.g., <code>\$GOPATH\src\github.com\goodmall\goodmall\pods\user</code>',

        ]);
    }

    /**
     * @inheritdoc
     */
    public function requiredTemplates()
    {
        return ['controller.go.php'];
    }

    /**
     * @inheritdoc
     */
    public function stickyAttributes()
    {
        return array_merge(parent::stickyAttributes(), [
//            'baseControllerClass', 'indexWidgetType'
        ]);
    }


    protected function getControllerFile()
    {
        // FIXME 此处的路径实际上可以有用户来直接输入  只输入一个podID 就定位文件路径 是有路径位置假设的
        // NOTE 如果采用了不同模板 路径可以不相同 可以根据模板和控制器路径做个简单映射 controllerPath4template =  [templateID => controllerPath]
        $controllerPathInPOD = 'adapters/api/gin/controller' ;

        $interactorFile =  implode(DIRECTORY_SEPARATOR,[
            $this->podPath,
            $this->podId,
            $controllerPathInPOD,
            $this->controllerType.'.go',
        ]);

        return $interactorFile ;
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $interactorFile =  $this->getControllerFile();

        $files = [
            new CodeFile($interactorFile, $this->render('controller.go.php')),
        ];

        // routes
        $routesFile = implode(DIRECTORY_SEPARATOR,[
            $this->podPath,
            $this->podId,
            'routes.go',
        ]);
        $files[]  =   new CodeFile($routesFile, $this->render('routes.go.php')) ;
        // 先生文件然后再删掉
        Yii::$app->on(Application::EVENT_AFTER_ACTION,function ()use($routesFile){
            if(file_exists($routesFile)){
                usleep(1000) ;
                unlink($routesFile) ;
            }

        });

        if (!empty($this->tableName)){
            $docFile = implode(DIRECTORY_SEPARATOR,[
                $this->podPath,
                $this->podId,
                'docs',
                $this->controllerType.'.go',
            ]);
            $params = [
               // 'fieldsInfo'=>$this->generateProperties($this->getTableSchema()),
            ];
            $files[]  =   new CodeFile($docFile, $this->render('docs.go.php',$params)) ;
        }

        return $files ;
        //
        if (!empty($this->searchModelClass)) {
            $searchModel = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->searchModelClass, '\\') . '.php'));
            $files[] = new CodeFile($searchModel, $this->render('search.php'));
        }

        $viewPath = $this->getViewPath();
        $templatePath = $this->getTemplatePath() . '/views';
        foreach (scandir($templatePath) as $file) {
            if (empty($this->searchModelClass) && $file === '_search.php') {
                continue;
            }
            if (is_file($templatePath . '/' . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $files[] = new CodeFile("$viewPath/$file", $this->render("views/$file"));
            }
        }

        return $files;
    }

    public function successMessage()
    {
        $return = $this->render('routes.go.php');
        $return .= '<br/><code>'.$return.'</code>';

        return $return;
    }

    /**
     * @return string the controller ID (without the module ID prefix)
     */
    public function getControllerID()
    {
        $pos = strrpos($this->controllerClass, '\\');
        $class = substr(substr($this->controllerClass, $pos + 1), 0, -10);

        return Inflector::camel2id($class);
    }



    public function getNameAttribute()
    {
        foreach ($this->getColumnNames() as $name) {
            if (!strcasecmp($name, 'name') || !strcasecmp($name, 'title')) {
                return $name;
            }
        }
        /* @var $class \yii\db\ActiveRecord */
        $class = $this->modelClass;
        $pk = $class::primaryKey();

        return $pk[0];
    }




    /**
     * Generates parameter tags for phpdoc
     * @return array parameter tags for phpdoc
     */
    public function generateActionParamComments()
    {
        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        $pks = $class::primaryKey();
        if (($table = $this->getTableSchema()) === false) {
            $params = [];
            foreach ($pks as $pk) {
                $params[] = '@param ' . (substr(strtolower($pk), -2) == 'id' ? 'integer' : 'string') . ' $' . $pk;
            }

            return $params;
        }
        if (count($pks) === 1) {
            return ['@param ' . $table->columns[$pks[0]]->phpType . ' $id'];
        } else {
            $params = [];
            foreach ($pks as $pk) {
                $params[] = '@param ' . $table->columns[$pk]->phpType . ' $' . $pk;
            }

            return $params;
        }
    }

    /**
     * Returns table schema for current model class or false if it is not an active record
     * @return bool|\yii\db\TableSchema
     */
    public function getTableSchema()
    {
       return   $this->getDbConnection()->getTableSchema($this->tableName) ;
    }


    /**
     * FIXME
     * Validates the [[tableName]] attribute.
     */
    public function validateTableName()
    {
       /*
        $ts =  $this->getTableSchema() ;
        if (empty($ts)) {
            $this->addError('tableName', "Table '{$this->tableName}' does not exist.");
        }
       */
    }
    /**
     * TODO 此处可改为go类型映射
     *
     * Generates the properties for the specified table.
     * @param \yii\db\TableSchema $table the table schema
     * @return array the generated properties (property => type)
     * @since 2.0.6
     */
    public function generateProperties($table)
    {
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
            /*
            if (!$column->allowNull && $column->defaultValue === null) {
                $types['required'][] = $column->name;
            }
            */
            // FIXME 这里关于可选值 总感觉怪怪的
            $properties[$column->name] = [
                'type' => $type,
                'name' => $column->name,
                'comment' => $column->comment,
                'isOptional' => $column->allowNull || $column->defaultValue !== null ,
                'default'=>$column->defaultValue ,
            ];
        }

        return $properties;
    }

    /**
     * 验证pods 路径是否存在
     *
     * @return void
     */
    public function validatePodPath()
    {
        if (!is_dir($this->podPath)) {
            $this->addError('podPath', ' please check the pod path which should exists： ' . $this->podPath);
        }
    }

    /**
     *
     * Generates the properties for the specified table.
     * @param \yii\db\TableSchema $table the table schema
     * @return array the generated fake record for table
     * @since 0.0.1
     */
    public function genFakeRecord($table)
    {
        $fakeRow = [] ;
        foreach ($table->columns as $column) {
            $columnPhpType = $column->phpType;
            $fakeRow[$column->name] =   \year\gii\goodmall\helpers\GiiantFaker::value(
                $columnPhpType,
                $column->name
            )  ;//  call_user_func_array(['year\gii\goodmall\helpers\GiiantFaker',$columnPhpType],[$column->name] );
           // $fakeRow[$column->name] =  GiiantFaker::{$columnPhpType};

        }
        return $fakeRow ;
    }

}
