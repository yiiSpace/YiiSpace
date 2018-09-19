<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace year\gii\yunying\generators\api;

use schmunk42\giiant\helpers\GiiantFaker;
use year\gii\yunying\Config;
use year\gii\yunying\utils\QualifiedTypeValidator;
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
 * api-controller path : yunying/yunying/pods/{podID}/adapters/api/gin/controller
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
class Generator extends  \yii\gii\generators\model\Generator
{


    /**
     * @var string
     */
    public $apiPath ;


    /**
     * @var string
     */
    public $tableName;




    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'yunying-API-Handler Generator';
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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apiPath'], 'required', 'message' => '选择api生成目录.'],

            [['template'], 'required', 'message' => 'A code template must be selected.'],
            [['template'], 'validateTemplate'],

            [['db',   'tableName', 'modelClass', ], 'filter', 'filter' => 'trim'],

            [['db', 'tableName', ], 'required'],
            [['db', 'modelClass', 'queryClass'], 'match', 'pattern' => '/^\w+$/', 'message' => 'Only word characters are allowed.'],
            [['ns', ], 'match', 'pattern' => '/^[\w\\\\]+$/', 'message' => 'Only word characters and backslashes are allowed.'],
            [['tableName'], 'match', 'pattern' => '/^([\w ]+\.)?([\w\* ]+)$/', 'message' => 'Only word characters, and optionally spaces, an asterisk and/or a dot are allowed.'],
            [['db'], 'validateDb'],
            [['tableName'], 'validateTableName'],
            [['modelClass'], 'validateModelClass', 'skipOnEmpty' => false],

            /*
            [['generateRelations'], 'in', 'range' => [self::RELATIONS_NONE, self::RELATIONS_ALL, self::RELATIONS_ALL_INVERSE]],
            [['generateLabelsFromComments', 'useTablePrefix', 'useSchemaName', 'generateQuery', 'generateRelationsFromCurrentSchema'], 'boolean'],
            [['enableI18N'], 'boolean'],
            [['messageCategory'], 'validateMessageCategory', 'skipOnEmpty' => false],
            */
        ];
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
        ]);
    }

    /**
     * @inheritdoc
     */
    public function requiredTemplates()
    {
        return ['service.js.php'];
    }


    /**
     * @inheritdoc
     */
    public function generate()
    {
        $apiServiceFile =  implode(DIRECTORY_SEPARATOR,[
             $this->apiPath,
             $this->modelClass . '.js',
        ]);

        $files = [
            new CodeFile($apiServiceFile, $this->render('service.js.php',[
                'serviceName'=>$this->generateClassName($this->tableName),
            ])),
        ];

        /*
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
        */

        return $files ;


    }

    public function successMessage()
    {
        $return = $this->render('routes.go.php');
        $return .= '<br/><code>'.$return.'</code>';

        return $return;
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
     * 验证路径是否存在
     *
     * @return void
     */
    public function validatePath()
    {
        if (!is_dir($this->apiPath)) {
            $this->addError('apiPath', ' please check the dir path which should exists： ' . $this->apiPath);
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
            $fakeRow[$column->name] =   \year\gii\yunying\helpers\GiiantFaker::value(
                $columnPhpType,
                $column->name
            )  ;//  call_user_func_array(['year\gii\yunying\helpers\GiiantFaker',$columnPhpType],[$column->name] );
           // $fakeRow[$column->name] =  GiiantFaker::{$columnPhpType};

        }
        return $fakeRow ;
    }

}
