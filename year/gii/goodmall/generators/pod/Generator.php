<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace year\gii\goodmall\generators\pod;

use Yii;
use yii\gii\CodeFile;
use yii\helpers\Html;
use yii\helpers\StringHelper;

/** @var string 辅助go服务的基地址 如 http://localhost:1323 */
const GiiBaseUrlKey = 'goodmall.giiBaseUrl' ;

/**
 * Undocumented class
 */
class Generator extends \yii\gii\Generator
{
    public function init()
    {
        parent::init() ;
        
        if (trim($this->getProjectHome()) != '') {
            $this->podsPath =  $this->getProjectHome().'\pods';
        }
    }
    /**
     * The pods path of project
     *
     * @var string
     */
    public $podsPath = '%GOPATH\github.com\goodmall\goodmall\pods';
   
    /**
     * ID of this pod
     *
     * @var string
     */
    public $podID;

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Goodmall-POD Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator helps you to generate the POD skeleton code needed by goodmall.';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [

            [['podsPath'], 'required'],
            [['podsPath'], 'filter', 'filter' => 'trim'],
            [['podsPath'], 'validatePodsPath'],

            [['podID',  ], 'filter', 'filter' => 'trim'],
            [['podID',  ], 'required'],
            [['podID'], 'match', 'pattern' => '/^[\w\\-]+$/', 'message' => 'Only word characters and dashes are allowed.'],
            
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                'podID' => 'POD ID',
                'podsPath' => 'pods path'];
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return [
            'podsPath' => 'the path where all pods will put at ,替换为你本机上pods的真实目录 ',
            'podID' => 'This refers to the ID of the Pod|module, e.g., <code>admin</code>.',
        ];
    }

    /**
     * @inheritdoc
     */
    public function successMessage()
    {
        $output = <<<EOD
<p>The module has been generated successfully.</p>
<p>To access the module, you need to add this to your application configuration:</p>
EOD;
        $code = <<<EOD
<?php
    ......
    
    考虑怎么集成到app去

    ......
EOD;

        return $output . '<pre>' . highlight_string($code, true) . '</pre>';
    }

    /**
     * @inheritdoc
     */
    public function requiredTemplates()
    {
        return ['readme.md.php',  'gitkeep.php'];
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $files = [];
        $modulePath = $this->podsPath;
        $podPath = $this->podsPath.'/'.$this->podID;
        $files[] = new CodeFile(
            $podPath . '/READEME.md',
            $this->render("readme.md.php")
        );

        $files[] = new CodeFile(
            $podPath . '/usecase/.gitkeep',
            $this->render("gitkeep.php")
        );
        
        $files[] = new CodeFile(
            $podPath . '/adapters/api/gin/init.go',
            $this->render("adapter-gin-init.go.php")
        );

        $files[] = new CodeFile(
            $podPath . '/domain/.gitkeep',
            $this->render("gitkeep.php")
        );

        $files[] = new CodeFile(
            $podPath . '/infra/repo/mysql/.gitkeep',
            $this->render("gitkeep.php")
        );

        $files[] = new CodeFile(
            $podPath . '/admin/.gitkeep',
            $this->render("gitkeep.php")
        );

        $files[] = new CodeFile(
            $podPath . '/migrations/.gitkeep',
            $this->render("gitkeep.php")
        );

        return $files;
    }

    /**
     * 验证pods 路径是否存在
     *
     * @return void
     */
    public function validatePodsPath()
    {
        if (!file_exists($this->podsPath)) {
            $this->addError('podsPath', ' please check the pods path which should must exists： ' . $this->podsPath);
        }
    }


    /**
     * 获取项目的根地址
     *
     * @return string
     */
    protected function getProjectHome()
    {
        // TODO 配置属性获取方式优雅化  year\gii\goodmall\generators\Config::getGiiBaseUrlKey() 弄个集中配置获取地方 把脏方式全部放一起去

        if(!empty(Yii::$app->params[GiiBaseUrlKey])){
            $giiEndpoint =  rtrim(Yii::$app->params[GiiBaseUrlKey] ,'/'). '/gii/project-home';
        }else{
            $giiEndpoint = 'http://localhost:1323/gii/project-home';
        }

        
        return  file_get_contents($giiEndpoint);

    }
}
