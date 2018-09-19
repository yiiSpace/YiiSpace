<?php

namespace year\gii\dva\generators\model;

use Yii;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use schmunk42\giiant\helpers\SaveForm;
use yii\helpers\VarDumper;

/**
 * This generator will generate one or multiple ActiveRecord classes for the specified database table.
 *
 * @author Tobias Munk <schmunk@usrbin.de>
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
        // 设置默认值 此处可以通过读取Yii的配置参数获取 比如 : Yii::$app->params['dva_src_dir'];
        if(empty($this->srcDir)){
            $this->srcDir = dirname(Yii::$app->basePath)
                .DIRECTORY_SEPARATOR.'frontend-dva'
                .DIRECTORY_SEPARATOR.'src' ;
        }
    }

    /**
     * @var string
     */
    public $srcDir ;


    /**
     * @see http://cball.me/organize-your-ember-app-with-pods/
     * 参考 .ember-cli
     *
     * @deprecated
     * @var bool
     */
    public $usePods = true ;


    /**
     * 如果指定了podName 证明使用 多模块|多仓 结构
     *
     * @var string
     */
    public $podName = '' ;

    /**
     * @var string
     */
    public $apiEndpoint = '' ;

    /**
     * @var null string for the table prefix, which is ignored in generated class name
     */
    public $tablePrefix = null;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Gii Dva';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '此生成器针对特定的数据库表 生成一套crud的react实现代码';
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

                // [['db', 'ns', 'tableName', 'baseClass', 'queryNs', 'queryBaseClass'], 'required'],
                [['db', 'ns', 'tableName',], 'required'],

                [['tablePrefix'], 'safe'],

                ['srcDir', 'string', 'message' => 'dva 项目的 src目录路径'],
                [['srcDir',], 'required','message'=>'你的dva项目src目录 本程序的路径：'.Yii::$app->basePath],

                ['podName', 'string', 'message' => 'dva 多仓位(yii的module含义)结构中的名称'],

                ['apiEndpoint', 'string', ],
                [['apiEndpoint',], 'required','message' => '对应的api path'],
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
        // 此处的名空间 指的是dva中的 而不是 yii系统中的
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'srcDir' => 'dva项目的src目录路径',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function hints()
    {
        $srcDir = Yii::$app->basePath ;
        return array_merge(
            parent::hints(),
            [
                'ns' => '模型的名空间, 这个是对应到全局状态的key去的 如果在状态和属性映射时这两者要一致的  e.g., <code>my_table_name</code>',
                'srcDir' => '默认路径是 项目根目录 ../xxx/src' . $srcDir,
                'podName' => 'dva 多仓位 (yii的module含义) 结构中的名称 <br/> 如果不指定表示不使用多仓结构 ',
            ]
        );
    }

    /**
     * Validates the [[modelClass]] attribute.
     */
    public function validateModelClass()
    {
        if ($this->isReservedKeyword($this->modelClass)) {
            $this->addError('modelClass', 'Class name cannot be a reserved PHP keyword.');
        }
        if ((empty($this->tableName) || substr_compare($this->tableName, '*', -1, 1)) && $this->modelClass == '') {
            $this->addError('modelClass', 'Model Class cannot be blank if table name does not end with asterisk.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function requiredTemplates()
    {
        return ['models/model.js.php',];
    }

    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        $files = [];
        $relations = $this->generateRelations();
        $db = $this->getDbConnection();

        foreach ($this->getTableNames() as $tableName) {
            list($relations, $translations) = array_values($this->extractTranslations($tableName, $relations));
//var_dump($relations,$tableName);exit;
            $className = php_sapi_name() === 'cli'
                ? $this->generateClassName($tableName)
                : $this->modelClass;

            $queryClassName = ($this->generateQuery) ? $this->generateQueryClassName($className) : false;
            $tableSchema = $db->getTableSchema($tableName);

            $params = [
                'tableName' => $tableName,
                'className' => $className,
                'queryClassName' => $queryClassName,
                'tableSchema' => $tableSchema,
                'labels' => $this->generateLabels($tableSchema),
                'hints' => $this->generateHints($tableSchema),
                'rules' => $this->generateRules($tableSchema),
                'relations' => isset($relations[$tableName]) ? $relations[$tableName] : [],
                'ns' => $this->ns,
                'enum' => $this->getEnum($tableSchema->columns),
            ];

            if (!empty($translations)) {
                $params['translation'] = $translations;
            }

            $params['blameable'] = $this->generateBlameable($tableSchema);
            $params['timestamp'] = $this->generateTimestamp($tableSchema);

            // 生model文件
            // pod 模式路径就不一样啦！
            $modelPath = implode(DIRECTORY_SEPARATOR,[
               $this->srcDir,
                'models',
                lcfirst($className).'.js',
            ]);
            $files[] = new CodeFile(
                $modelPath,
                $this->render('models/model.js.php', $params)
            );


            // 生model 对应的service 文件
            // pod 模式路径就不一样啦！
            $modelPath = implode(DIRECTORY_SEPARATOR,[
                $this->srcDir,
                'services',
                lcfirst($className).'.js',
            ]);
            $files[] = new CodeFile(
                $modelPath,
                $this->render('services/model.js.php', $params)
            );


            // 生model 对应的 编辑模型 文件
            // pod 模式路径就不一样啦！
            $modelPath = implode(DIRECTORY_SEPARATOR,[
                $this->srcDir,
                'components',
                $className,
                ($className).'Modal.js',
            ]);
            $files[] = new CodeFile(
                $modelPath,
                $this->render('components/FormModal.js.php', $params)
            );

            $modelPath = implode(DIRECTORY_SEPARATOR,[
                $this->srcDir,
                'components',
                $className,
                $className.'.js',
            ]);
            $files[] = new CodeFile(
                $modelPath,
                $this->render('components/ModelList.js.php', $params)
            );
            //  样式文件
            $stylePath = implode(DIRECTORY_SEPARATOR,[
                $this->srcDir,
                'components',
                $className,
                $className.'.css',
            ]);
            $files[] = new CodeFile(
                $stylePath,
                $this->render('components/model.css.php', $params)
            );

            // container Component 容器组件
            $containerComponentPath = implode(DIRECTORY_SEPARATOR,[
                $this->srcDir,
                'routes',
                ($className).'.js',
            ]);
            $files[] = new CodeFile(
                $containerComponentPath,
                $this->render('routes/ModelContainer.jsx.php', $params)
            );
            $containerComponentCssPath = implode(DIRECTORY_SEPARATOR,[
                $this->srcDir,
                'routes',
                ($className).'.css',
            ]);
            $files[] = new CodeFile(
                $containerComponentCssPath,
                $this->render('routes/Model.css.php', $params)
            );

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
<p>The dva crud suite  has been generated successfully.</p>
<p> 为了能够玩耍起来  你需要配置你的路由文件  src/router.js , you need to add this to your application configuration:</p>
EOD;

         $routePath = Inflector::camel2id(StringHelper::basename($this->modelClass)) ;
        $modelPathName = lcfirst($this->modelClass) ;

         $modelNaneWords = Inflector::camel2words($this->modelClass) ;

        $code = <<<EOD
<?php
    // src/router.js
    ......
    {
      path: '{$routePath}',
      name: '{$this->modelClass}Page',
      getComponent(nextState, cb) {
        require.ensure([], (require) => {
          registerModel(app, require('./models/{$modelPathName}'));
          cb(null, require('./routes/{$this->modelClass}'));
        });
      },
    },
    ......
    // 另外需要在主菜单中挂接下
    ~~~js
    
      // src/components/MainLayout/Header.js
      
      <Menu.Item key="/{$routePath}">
        <Link to="/{$routePath}"><Icon type="bars" />{$modelNaneWords}</Link>
      </Menu.Item>
    ~~~
EOD;

        return $output . '<pre>' . highlight_string($code, true) . '</pre>';
    }
}
